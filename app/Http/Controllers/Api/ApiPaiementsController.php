<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Paiements;
use Illuminate\Http\Request;

class ApiPaiementsController extends Controller
{
    // ✅ 1. Liste (ou first) des paiements d’un utilisateur
    public function getPaiementByUser($id_utilisateur)
    {
        $paiement = Paiements::where('id_utilisateur', $id_utilisateur)
            ->with(['reservation'])
            ->first();

        if (!$paiement) {
            return response()->json(['message' => 'Aucun paiement trouvé'], 404);
        }

        return response()->json($paiement);
    }

    // ✅ 2. Création d’un paiement
    public function store(Request $request)
    {
        $validated = $request->validate([
            'montant' => 'required|numeric',
            'mode_paiement' => 'required|string',
            'reference' => 'required|string|unique:paiements,reference',
            'statut' => 'required|string',
            'id_utilisateur' => 'required|integer',
            'id_reservation' => 'required|integer',
        ]);

        $paiement = Paiements::create($validated);

        return response()->json([
            'message' => 'Paiement enregistré avec succès',
            'data' => $paiement
        ], 201);
    }

    // ✅ 3. Mise à jour d’un paiement
    public function update(Request $request, $id_paiement)
    {
        $paiement = Paiements::find($id_paiement);

        if (!$paiement) {
            return response()->json(['message' => 'Paiement non trouvé'], 404);
        }

        $paiement->update($request->all());

        return response()->json([
            'message' => 'Paiement mis à jour avec succès',
            'data' => $paiement
        ]);
    }

    // ✅ 4. Suppression d’un paiement
    public function destroy($id_paiement)
    {
        $paiement = Paiements::find($id_paiement);

        if (!$paiement) {
            return response()->json(['message' => 'Paiement non trouvé'], 404);
        }

        $paiement->delete();

        return response()->json(['message' => 'Paiement supprimé avec succès']);
    }
}
