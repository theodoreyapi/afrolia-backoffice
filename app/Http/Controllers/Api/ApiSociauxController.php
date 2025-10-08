<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Sociaux;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiSociauxController extends Controller
{
    public function getSociauxByUser($id)
    {
        $sociaux = Sociaux::where('id_utilisateur', $id)->first();

        if (!$sociaux) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun réseau social trouvé pour cet utilisateur'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $sociaux
        ]);
    }

    public function saveSociaux(Request $request)
    {
        $rules = [
            'id_utilisateur' => 'required|integer|exists:users_app,id_user_app',
            'instagram' => 'nullable|string',
            'facebook' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'tiktok' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => collect($validator->errors()->all())
            ], 422);
        }

        // Chercher si l'utilisateur a déjà des réseaux sociaux
        $sociaux = Sociaux::where('id_utilisateur', $request->id_utilisateur)->first();

        if ($sociaux) {
            // Mise à jour
            $sociaux->update($request->only(['instagram', 'facebook', 'whatsapp', 'tiktok']));
            $message = 'Informations sociales mises à jour avec succès';
        } else {
            // Création
            $sociaux = Sociaux::create($request->only(['instagram', 'facebook', 'whatsapp', 'tiktok', 'id_utilisateur']));
            $message = 'Informations sociales créées avec succès';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $sociaux
        ]);
    }

    public function getGalleryByUser($id)
    {
        $gallery = Gallery::where('id_utilisateur', $id)->get();

        return response()->json([
            'success' => true,
            'data' => $gallery
        ]);
    }

    public function createGallery(Request $request)
    {
        $rules = [
            'id_utilisateur' => 'required|integer|exists:users_app,id_user_app',
            'images' => 'required|array',
            'images.*.image' => 'required|string', // ici tu peux adapter si tu uploades des fichiers
            'images.*.description' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => collect($validator->errors()->all())
            ], 422);
        }

        $createdImages = [];
        foreach ($request->images as $img) {
            $img['id_utilisateur'] = $request->id_utilisateur;
            $createdImages[] = Gallery::create($img);
        }

        return response()->json([
            'success' => true,
            'message' => 'Images ajoutées avec succès',
            'data' => $createdImages
        ]);
    }

    public function updateGallery(Request $request, $id)
    {
        $gallery = Gallery::find($id);

        if (!$gallery) {
            return response()->json([
                'success' => false,
                'message' => 'Image introuvable'
            ], 404);
        }

        $rules = [
            'image' => 'sometimes|required|string', // ou file selon ton upload
            'description' => 'sometimes|nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => collect($validator->errors()->all())
            ], 422);
        }

        $gallery->update($request->only(['image', 'description']));

        return response()->json([
            'success' => true,
            'message' => 'Image mise à jour avec succès',
            'data' => $gallery
        ]);
    }

    public function deleteGallery($id_gallery)
    {
        $gallery = Gallery::find($id_gallery);

        if (!$gallery) {
            return response()->json([
                'success' => false,
                'message' => 'Image introuvable'
            ], 404);
        }

        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image supprimée avec succès'
        ]);
    }

    
}
