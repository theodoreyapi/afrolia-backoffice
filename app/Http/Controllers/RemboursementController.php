<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RemboursementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->intended('index');
        }

        // En attente : réservation annulée, déjà payée, pas encore remboursée
        $attente = DB::table('reservations')
            ->where('statut', 'annulee')
            ->where('statut_paiement', 'paye')
            ->count();

        $remboursements = DB::table('reservations')
            ->join('users_app as clients', 'reservations.id_client', '=', 'clients.id_user_app')
            ->join('users_app as coiffeuses', 'reservations.id_coiffeur', '=', 'coiffeuses.id_user_app')
            ->where('reservations.statut', 'annulee')
            ->whereIn('reservations.statut_paiement', ['paye', 'rembourse'])
            ->select(
                'reservations.*',
                'clients.name as client_prenom',
                'clients.last_name as client_nom',
                'clients.phone as client_phone',
                'clients.photo as client_photo',
                'coiffeuses.name as coiffeuse_prenom',
                'coiffeuses.last_name as coiffeuse_nom',
                'coiffeuses.phone as coiffeuse_phone',
                'coiffeuses.photo as coiffeuse_photo'
            )
            ->orderByDesc('reservations.annule_le')
            ->get();

        return view('publicites.remboursement', compact('attente', 'remboursements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Traiter un remboursement (marquer comme remboursé).
     */
    public function traiter(string $id)
    {
        $reservation = DB::table('reservations')->where('id_reservation', $id)->first();

        if (!$reservation) {
            return back()->withErrors(['Réservation introuvable.']);
        }

        DB::table('reservations')
            ->where('id_reservation', $id)
            ->update(['statut_paiement' => 'rembourse']);

        DB::table('paiements')
            ->where('id_reservation', $id)
            ->update([
                'status'       => 'refunded',
                'processed_at' => now(),
            ]);

        return back()->with('succes', 'Le remboursement a été traité.');
    }

    /**
     * Rejeter une demande de remboursement.
     */
    public function rejeter(Request $request, string $id)
    {
        $request->validate([
            'raison' => 'required|string|max:500',
        ], [
            'raison.required' => 'Veuillez indiquer la raison du rejet.',
        ]);

        $reservation = DB::table('reservations')->where('id_reservation', $id)->first();

        if (!$reservation) {
            return back()->withErrors(['Réservation introuvable.']);
        }

        DB::table('reservations')
            ->where('id_reservation', $id)
            ->update([
                'notes' => trim(($reservation->notes ? $reservation->notes . ' | ' : '') . 'Remboursement rejeté: ' . $request->raison),
            ]);

        return back()->with('succes', 'La demande de remboursement a été rejetée.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
