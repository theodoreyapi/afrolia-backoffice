<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RapportController extends Controller
{
    private function checkAuth()
    {
        if (!Auth::check()) {
            return redirect()->intended('index');
        }
        return null;
    }

    /**
     * Rapport financier mensuel.
     */
    public function financier()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $monthlyRaw = DB::table('gains')
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month_key,
                SUM(montant_brut) as brut, SUM(montant_commission) as commission, SUM(montant_net) as net")
            ->groupByRaw("DATE_FORMAT(created_at, '%Y-%m')")
            ->get()
            ->keyBy('month_key');

        $months = [];
        $bruts = [];
        $commissions = [];
        $nets = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $key = $date->format('Y-m');
            $row = $monthlyRaw->get($key);
            $months[] = ucfirst($date->translatedFormat('M Y'));
            $bruts[] = (float) ($row->brut ?? 0);
            $commissions[] = (float) ($row->commission ?? 0);
            $nets[] = (float) ($row->net ?? 0);
        }

        $totalBrut = array_sum($bruts);
        $totalCommission = array_sum($commissions);
        $totalNet = array_sum($nets);

        $moisCourant = now()->format('Y-m');
        $revenuMoisCourant = (float) ($monthlyRaw->get($moisCourant)->brut ?? 0);
        $moisPrecedent = now()->subMonth()->format('Y-m');
        $revenuMoisPrecedent = (float) ($monthlyRaw->get($moisPrecedent)->brut ?? 0);
        $evolution = $revenuMoisPrecedent > 0
            ? round((($revenuMoisCourant - $revenuMoisPrecedent) / $revenuMoisPrecedent) * 100, 1)
            : null;

        return view('rapports.financier', compact(
            'months',
            'bruts',
            'commissions',
            'nets',
            'totalBrut',
            'totalCommission',
            'totalNet',
            'evolution'
        ));
    }

    /**
     * Statistiques utilisateurs.
     */
    public function utilisateurs()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $totalClients   = DB::table('users_app')->where('role', 'user')->count();
        $totalCoiffeuses = DB::table('users_app')->where('role', 'hair')->count();
        $clientsActifs  = DB::table('users_app')->where('role', 'user')->where('statut', 'Active')->count();
        $coiffeusesActives = DB::table('users_app')->where('role', 'hair')->where('statut', 'Active')->count();

        // Nouvelles inscriptions par mois (12 derniers mois)
        $inscriptionsRaw = DB::table('users_app')
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month_key, role, COUNT(*) as total")
            ->groupByRaw("DATE_FORMAT(created_at, '%Y-%m'), role")
            ->get()
            ->groupBy('month_key');

        $months = [];
        $clientsParMois = [];
        $coiffeusesParMois = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $key = $date->format('Y-m');
            $rows = $inscriptionsRaw->get($key, collect());
            $months[] = ucfirst($date->translatedFormat('M Y'));
            $clientsParMois[] = (int) ($rows->firstWhere('role', 'user')->total ?? 0);
            $coiffeusesParMois[] = (int) ($rows->firstWhere('role', 'hair')->total ?? 0);
        }

        // Top clients par dépenses
        $topClients = DB::table('users_app')
            ->join('reservations', 'users_app.id_user_app', '=', 'reservations.id_client')
            ->where('users_app.role', 'user')
            ->where('reservations.statut_paiement', 'paye')
            ->select('users_app.id_user_app', 'users_app.name', 'users_app.last_name', 'users_app.photo')
            ->selectRaw('SUM(reservations.montant_total) as total_depense, COUNT(reservations.id_reservation) as nb_reservations')
            ->groupBy('users_app.id_user_app', 'users_app.name', 'users_app.last_name', 'users_app.photo')
            ->orderByDesc('total_depense')
            ->limit(5)
            ->get();

        return view('rapports.utilisateurs', compact(
            'totalClients',
            'totalCoiffeuses',
            'clientsActifs',
            'coiffeusesActives',
            'months',
            'clientsParMois',
            'coiffeusesParMois',
            'topClients'
        ));
    }

    /**
     * Performances des réservations.
     */
    public function reservations()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $total = DB::table('reservations')->count();
        $terminees = DB::table('reservations')->where('statut', 'terminee')->count();
        $annulees = DB::table('reservations')->where('statut', 'annulee')->count();
        $noShow = DB::table('reservations')->where('statut', 'no_show')->count();

        $tauxCompletion = $total > 0 ? round(($terminees / $total) * 100, 1) : 0;
        $tauxAnnulation = $total > 0 ? round(($annulees / $total) * 100, 1) : 0;
        $tauxNoShow = $total > 0 ? round(($noShow / $total) * 100, 1) : 0;

        // Répartition par statut
        $parStatut = DB::table('reservations')
            ->selectRaw('statut, COUNT(*) as total')
            ->groupBy('statut')
            ->pluck('total', 'statut');

        // Répartition par spécialité (services les plus réservés)
        $parSpecialite = DB::table('reservations')
            ->join('services', 'reservations.id_service', '=', 'services.id_service')
            ->join('specialites', 'services.id_speciale', '=', 'specialites.id_specialite')
            ->selectRaw('specialites.libelle, COUNT(*) as total')
            ->groupBy('specialites.libelle')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        // Réservations par mois (12 derniers mois)
        $monthlyRaw = DB::table('reservations')
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month_key, COUNT(*) as total")
            ->groupByRaw("DATE_FORMAT(created_at, '%Y-%m')")
            ->pluck('total', 'month_key');

        $months = [];
        $reservationsParMois = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $key = $date->format('Y-m');
            $months[] = ucfirst($date->translatedFormat('M Y'));
            $reservationsParMois[] = (int) ($monthlyRaw[$key] ?? 0);
        }

        return view('rapports.reservations', compact(
            'total',
            'terminees',
            'annulees',
            'noShow',
            'tauxCompletion',
            'tauxAnnulation',
            'tauxNoShow',
            'parStatut',
            'parSpecialite',
            'months',
            'reservationsParMois'
        ));
    }

    /**
     * Satisfaction client.
     */
    public function satisfaction()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $totalAvis = DB::table('reviews')->where('status', 'approved')->count();
        $noteMoyenne = DB::table('reviews')->where('status', 'approved')->avg('rating');

        $repartition = DB::table('reviews')
            ->where('status', 'approved')
            ->selectRaw('rating, COUNT(*) as total')
            ->groupBy('rating')
            ->pluck('total', 'rating');

        $repartitionData = [];
        for ($i = 1; $i <= 5; $i++) {
            $repartitionData[$i] = (int) ($repartition[$i] ?? 0);
        }

        // Top coiffeuses par note moyenne (min 3 avis pour être significatif)
        $topCoiffeuses = DB::table('reviews')
            ->join('users_app', 'reviews.id_stylist', '=', 'users_app.id_user_app')
            ->where('reviews.status', 'approved')
            ->select('users_app.id_user_app', 'users_app.name', 'users_app.last_name', 'users_app.photo')
            ->selectRaw('AVG(reviews.rating) as note_moyenne, COUNT(reviews.id_review) as nb_avis')
            ->groupBy('users_app.id_user_app', 'users_app.name', 'users_app.last_name', 'users_app.photo')
            ->havingRaw('COUNT(reviews.id_review) >= 3')
            ->orderByDesc('note_moyenne')
            ->limit(5)
            ->get();

        // Avis récents nécessitant attention (note <= 2)
        $avisNegatifs = DB::table('reviews')
            ->join('users_app as clients', 'reviews.id_client', '=', 'clients.id_user_app')
            ->join('users_app as stylists', 'reviews.id_stylist', '=', 'stylists.id_user_app')
            ->where('reviews.status', 'approved')
            ->where('reviews.rating', '<=', 2)
            ->select(
                'reviews.*',
                'clients.name as client_prenom',
                'clients.last_name as client_nom',
                'stylists.name as stylist_prenom',
                'stylists.last_name as stylist_nom'
            )
            ->orderByDesc('reviews.created_at')
            ->limit(10)
            ->get();

        return view('rapports.satisfaction', compact(
            'totalAvis',
            'noteMoyenne',
            'repartitionData',
            'topCoiffeuses',
            'avisNegatifs'
        ));
    }
}
