<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservations;
use Illuminate\Http\Request;

class ApiReservationsController extends Controller
{
    // ✅ 1. Liste des réservations d’un utilisateur (first)
    public function getReservationByUser($id)
    {
        $reservation = Reservations::where('id_utilisateur', $id)
            ->with(['service'])
            ->first();

        if (!$reservation) {
            return response()->json(['message' => 'Aucune réservation trouvée'], 404);
        }

        return response()->json($reservation);
    }

    // ✅ 2. Création d’une réservation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_reservation' => 'required|date',
            'heure_reservation' => 'required',
            'statut' => 'required|string',
            'id_utilisateur' => 'required|integer',
            'id_service' => 'required|integer',
        ]);

        $reservation = Reservations::create($validated);
        return response()->json([
            'message' => 'Réservation créée avec succès',
            'data' => $reservation
        ], 201);
    }

    // ✅ 3. Mise à jour d’une réservation
    public function update(Request $request, $id)
    {
        $reservation = Reservations::find($id);

        if (!$reservation) {
            return response()->json(['message' => 'Réservation non trouvée'], 404);
        }

        $reservation->update($request->all());
        return response()->json([
            'message' => 'Réservation mise à jour avec succès',
            'data' => $reservation
        ]);
    }

    // ✅ 4. Suppression d’une réservation
    public function destroy($id)
    {
        $reservation = Reservations::find($id);

        if (!$reservation) {
            return response()->json(['message' => 'Réservation non trouvée'], 404);
        }

        $reservation->delete();
        return response()->json(['message' => 'Réservation supprimée avec succès']);
    }
}
