<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->intended('index');
        }

        $succeeded  = DB::table('paiements')->where('status', 'succeeded')->count();
        $failed     = DB::table('paiements')->where('status', 'failed')->count();
        $pending    = DB::table('paiements')->where('status', 'pending')->count();
        $refunded   = DB::table('paiements')->where('status', 'refunded')->count();

        $paiements = DB::table('paiements')
            ->join('reservations', 'paiements.id_reservation', '=', 'reservations.id_reservation')
            ->join('users_app as coiffeuses', 'reservations.id_coiffeur', '=', 'coiffeuses.id_user_app')
            ->select(
                'paiements.*',
                'reservations.numero_reservation',
                'reservations.prix_service',
                'reservations.montant_commission',
                'reservations.montant_total',
                'coiffeuses.name as coiffeuse_prenom',
                'coiffeuses.last_name as coiffeuse_nom',
                'coiffeuses.phone as coiffeuse_phone',
                'coiffeuses.photo as coiffeuse_photo'
            )
            ->orderByDesc('paiements.created_at')
            ->get();

        return view('publicites.publicites', compact(
            'paiements',
            'succeeded',
            'failed',
            'pending',
            'refunded'
        ));
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
