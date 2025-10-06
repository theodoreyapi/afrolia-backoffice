<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Helps;
use App\Models\Security;
use Illuminate\Http\Request;

class ApiSecurityController extends Controller
{
    public function helps()
    {

        $helps = Helps::select('description')->first();

        if ($helps) {

            return response()->json([
                'success' => true,
                'message' => 'Connexion réussie',
                'data' => $helps->description,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Aide et support non disponibles.",
            ], 401);
        }
    }
    public function security()
    {

        $helps = Security::select('description')->first();

        if ($helps) {

            return response()->json([
                'success' => true,
                'message' => 'Connexion réussie',
                'data' => $helps->description,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Confidentialite non disponible.",
            ], 401);
        }
    }
}
