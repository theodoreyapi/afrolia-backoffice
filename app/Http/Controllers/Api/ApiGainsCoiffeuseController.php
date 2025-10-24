<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gains;
use Illuminate\Http\Request;

class ApiGainsCoiffeuseController extends Controller
{
    // ✅ 1. Récupérer les gains d’une coiffeuse (user)
    public function getGainsByUser($id_utilisateur)
    {
        $gains = Gains::where('id_utilisateur', $id_utilisateur)
            ->orderBy('periode', 'desc')
            ->get();

        if ($gains->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun gain trouvé pour cette coiffeuse'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Liste des gains de la coiffeuse',
            'data' => $gains
        ]);
    }

    // ✅ 2. Création d’un gain
    public function store(Request $request)
    {
        $validated = $request->validate([
            'montant' => 'required|numeric',
            'commission' => 'required|numeric',
            'net' => 'required|numeric',
            'periode' => 'required|string',
            'id_utilisateur' => 'required|integer',
            'id_paiement' => 'nullable|integer',
        ]);

        $gain = Gains::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Gain enregistré avec succès',
            'data' => $gain
        ], 201);
    }

    // ✅ 3. Mise à jour d’un gain
    public function update(Request $request, $id_gain_coiffeuse)
    {
        $gain = Gains::find($id_gain_coiffeuse);

        if (!$gain) {
            return response()->json([
                'success' => false,
                'message' => 'Gain introuvable'
            ], 404);
        }

        $gain->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Gain mis à jour avec succès',
            'data' => $gain
        ]);
    }

    // ✅ 4. Suppression d’un gain
    public function destroy($id_gain_coiffeuse)
    {
        $gain = Gains::find($id_gain_coiffeuse);

        if (!$gain) {
            return response()->json([
                'success' => false,
                'message' => 'Gain introuvable'
            ], 404);
        }

        $gain->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gain supprimé avec succès'
        ]);
    }
}
