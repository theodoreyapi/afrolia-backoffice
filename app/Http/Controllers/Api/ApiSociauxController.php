<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Sociaux;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApiSociauxController extends Controller
{
    public function getSociauxByUser($id)
    {
        $sociaux = Sociaux::where('id_utilisateur', $id)
            ->select('instagram', 'facebook', 'whatsapp', 'tiktok', 'id_sociaux', 'id_utilisateur')
            ->first();

        if (!$sociaux) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun réseau social trouvé pour cet utilisateur'
            ], 404);
        }

        return response()->json($sociaux);
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
        $gallery = Gallery::where('id_utilisateur', $id)
            ->select('id_gallery', 'image')
            ->get();

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
            'images.*.image' => 'required|file|mimes:jpg,jpeg,png,webp|max:5120',
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

        // 🔁 Parcourir chaque image reçue
        foreach ($request->images as $index => $img) {
            $file = $request->file("images.$index.image");

            if ($file && $file->isValid()) {
                $timestamp = Carbon::now()->format('Ymd_His');
                $photoName = 'gallery_' . $timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // 📂 Enregistre dans public/salon/gallery
                $file->move(public_path('salon/gallery'), $photoName);

                // 🔗 URL publique
                $photoUrl = url('afrolia/public/salon/gallery/' . $photoName);

                $createdImages[] = Gallery::create([
                    'id_utilisateur' => $request->id_utilisateur,
                    'image' => $photoUrl,
                    'description' => $img['description'] ?? '',
                ]);
            }
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
            'image' => 'sometimes|file|image|max:5120',
            'description' => 'sometimes|nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => collect($validator->errors()->all())
            ], 422);
        }

        // Suppression de l'ancienne image si une nouvelle est envoyée
        if ($request->hasFile('image')) {
            if ($gallery->image) {
                $anciennePhotoPath = str_replace('/storage/', '', $gallery->image);
                Storage::disk('public')->delete($anciennePhotoPath);
            }

            $timestamp = Carbon::now()->format('Ymd_His');
            $photoName = 'gallery_' . $timestamp . '.' . $request->file('image')->getClientOriginalExtension();
            $photoPath = $request->file('image')->storeAs('utilisateurs/gallery', $photoName, 'public');
            $gallery->image = Storage::url($photoPath);
        }

        if ($request->filled('description')) {
            $gallery->description = $request->description;
        }

        $gallery->save();

        return response()->json([
            'success' => true,
            'message' => 'Image mise à jour avec succès',
            'data' => $gallery
        ]);
    }

    public function deleteGallery($id)
    {
        $gallery = Gallery::find($id);

        if (!$gallery) {
            return response()->json([
                'success' => false,
                'message' => 'Image introuvable'
            ], 404);
        }

        // 🧹 Supprimer physiquement le fichier du dossier public
        if (!empty($gallery->image)) {
            // Extraire le chemin local à partir de l’URL complète
            $imagePath = public_path(parse_url($gallery->image, PHP_URL_PATH));

            if (file_exists($imagePath)) {
                @unlink($imagePath); // Supprime le fichier sans bloquer en cas d’erreur
            }
        }

        // 🗑️ Supprimer l’enregistrement en base
        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image supprimée avec succès'
        ]);
    }
}
