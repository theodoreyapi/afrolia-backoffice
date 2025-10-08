<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiServicesController extends Controller
{

    public function createServices(Request $request)
    {
        $rules = [
            'id_utilisateur' => 'required|integer|exists:users_app,id_user_app',
            'services' => 'required|array',
            'services.*.prix' => 'required|numeric',
            'services.*.minute' => 'required|integer',
            'services.*.description' => 'required|string',
            'services.*.commission' => 'required|numeric',
            'services.*.id_speciale' => 'required|integer|exists:specialites,id_specialite',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => collect($validator->errors()->all())
            ], 422);
        }

        $createdServices = [];
        foreach ($request->services as $serviceData) {
            $serviceData['id_utilisateur'] = $request->id_utilisateur;
            $createdServices[] = Services::create($serviceData);
        }

        return response()->json([
            'success' => true,
            'message' => 'Services créés avec succès',
            'data' => $createdServices
        ]);
    }


    public function updateService(Request $request, $id)
    {
        $service = Services::find($id);

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Service introuvable'
            ], 404);
        }

        $rules = [
            'prix' => 'sometimes|required|numeric',
            'minute' => 'sometimes|required|integer',
            'description' => 'sometimes|required|string',
            'commission' => 'sometimes|required|numeric',
            'id_speciale' => 'sometimes|required|integer|exists:specialites,id_specialite',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => collect($validator->errors()->all())
            ], 422);
        }

        $service->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Service mis à jour avec succès',
            'data' => $service
        ]);
    }

    public function deleteService($id_service)
    {
        $service = Services::find($id_service);

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Service introuvable'
            ], 404);
        }

        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'Service supprimé avec succès'
        ]);
    }
}
