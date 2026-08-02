<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LitigeController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->intended('index');
        }

        $ouverts   = DB::table('litiges')->where('statut', 'ouvert')->count();
        $enCours   = DB::table('litiges')->where('statut', 'en_cours')->count();
        $resolus   = DB::table('litiges')->where('statut', 'resolu')->count();
        $rejetes   = DB::table('litiges')->where('statut', 'rejete')->count();

        $litiges = DB::table('litiges')
            ->join('reservations', 'litiges.id_reservation', '=', 'reservations.id_reservation')
            ->join('users_app as plaignants', 'litiges.id_plaignant', '=', 'plaignants.id_user_app')
            ->select(
                'litiges.*',
                'reservations.numero_reservation',
                'plaignants.name as plaignant_prenom',
                'plaignants.last_name as plaignant_nom',
                'plaignants.photo as plaignant_photo',
                'plaignants.phone as plaignant_phone'
            )
            ->orderByDesc('litiges.created_at')
            ->get();

        return view('litiges.litiges', compact('ouverts', 'enCours', 'resolus', 'rejetes', 'litiges'));
    }

    public function resoudre(Request $request, string $id)
    {
        $request->validate([
            'resolution' => 'required|string|max:1000',
        ], [
            'resolution.required' => 'Veuillez décrire la résolution apportée.',
        ]);

        DB::table('litiges')->where('id_litige', $id)->update([
            'statut'     => 'resolu',
            'resolution' => $request->resolution,
            'resolu_le'  => now(),
            'updated_at' => now(),
        ]);

        return back()->with('succes', 'Le litige a été marqué comme résolu.');
    }

    public function rejeter(Request $request, string $id)
    {
        $request->validate([
            'resolution' => 'required|string|max:1000',
        ], [
            'resolution.required' => 'Veuillez indiquer la raison du rejet.',
        ]);

        DB::table('litiges')->where('id_litige', $id)->update([
            'statut'     => 'rejete',
            'resolution' => $request->resolution,
            'resolu_le'  => now(),
            'updated_at' => now(),
        ]);

        return back()->with('succes', 'Le litige a été rejeté.');
    }

    public function enCours(string $id)
    {
        DB::table('litiges')->where('id_litige', $id)->update([
            'statut'     => 'en_cours',
            'updated_at' => now(),
        ]);

        return back()->with('succes', 'Le litige est maintenant en cours de traitement.');
    }
}
