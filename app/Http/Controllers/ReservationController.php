<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->intended('index');
        }

        $terminee  = DB::table('reservations')->where('statut', 'terminee')->count();
        $enattente = DB::table('reservations')->where('statut', 'en_attente')->count();
        $confirmee = DB::table('reservations')->where('statut', 'confirmee')->count();
        $annulee   = DB::table('reservations')->where('statut', 'annulee')->count();

        $reservations = DB::table('reservations')
            ->join('users_app as clients', 'reservations.id_client', '=', 'clients.id_user_app')
            ->join('users_app as coiffeuses', 'reservations.id_coiffeur', '=', 'coiffeuses.id_user_app')
            ->join('services', 'reservations.id_service', '=', 'services.id_service')
            ->join('specialites', 'services.id_speciale', '=', 'specialites.id_specialite')
            ->leftJoin('reviews', 'reviews.id_reservation', '=', 'reservations.id_reservation')
            ->select(
                'reservations.*',
                'clients.name as client_prenom',
                'clients.last_name as client_nom',
                'clients.phone as client_phone',
                'clients.photo as client_photo',
                'coiffeuses.name as coiffeuse_prenom',
                'coiffeuses.last_name as coiffeuse_nom',
                'coiffeuses.phone as coiffeuse_phone',
                'coiffeuses.photo as coiffeuse_photo',
                'specialites.libelle as service_libelle',
                'services.minute as service_duree',
                'reviews.rating as review_rating',
                'reviews.comment as review_comment',
                'reviews.created_at as review_created_at'
            )
            ->orderByDesc('reservations.created_at')
            ->get();

        return view('events.events', compact('terminee', 'enattente', 'confirmee', 'annulee', 'reservations'));
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
