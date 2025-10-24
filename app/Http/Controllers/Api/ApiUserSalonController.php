<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Disponibilites;
use App\Models\Heures;
use App\Models\Jours;
use App\Models\Langues;
use App\Models\Specialites;
use App\Models\UsersApp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApiUserSalonController extends Controller
{
    public function updateInfoBasic(Request $request, $id)
    {
        $utilisateur = UsersApp::findOrFail($id);

        $rules = [
            'nom' => 'sometimes|required|string',
            'prenom' => 'sometimes|required|string',
            'commune' => 'sometimes|required|string',
            'adresse' => 'nullable|string',
            'email' => 'nullable|string',
            'experience' => 'nullable',
            'password' => 'nullable|string',
            'photo' => 'nullable|image',
        ];

        $messages = [
            'nom.required' => 'Veuillez saisir votre nom.',
            'prenom.required' => 'Veuillez saisir votre prénom.',
            'phone.required' => 'Veuillez saisir votre numéro de téléphone.',
            'phone.unique' => 'Le numéro de téléphone est deja utilisé.',
            'commune.required' => 'Veuillez saisir votre commune.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => collect($validator->errors()->all()),
            ], 422);
        }

        if ($request->hasFile('photo')) {
            // supprimer l'ancienne photo si elle existe
            if ($utilisateur->photo_utilisateur) {
                $anciennePhotoPath = str_replace('/storage/', '', $utilisateur->photo_utilisateur);
                Storage::disk('public')->delete($anciennePhotoPath);
            }

            $timestamp = Carbon::now()->format('Ymd_His');
            $photo = $request->file('photo');
            $photoName = 'photo_' . $timestamp . '.' . $photo->getClientOriginalExtension();
            $photoPath = $photo->storeAs('utilisateurs/photos', $photoName, 'public');
            $utilisateur->photo_utilisateur = Storage::url($photoPath);
        }

        // Mise à jour des champs modifiables
        if ($request->filled('nom')) {
            $utilisateur->name = $request->nom;
        }

        if ($request->filled('prenom')) {
            $utilisateur->last_name = $request->prenom;
        }
        if ($request->filled('commune')) {
            $utilisateur->commune = $request->commune;
        }
        if ($request->filled('adresse')) {
            $utilisateur->adresse = $request->adresse;
        }
        if ($request->filled('experience')) {
            $utilisateur->experience = (int) $request->experience;
        }
        if ($request->filled('email')) {
            $utilisateur->email = $request->email;
        }
        if ($request->filled('password')) {
            $utilisateur->password = Hash::make($request->password);
        }

        if ($utilisateur->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Informations mises à jour avec succès',
                'photo' => url($utilisateur->photo)
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Impossible de mettre à jour vos informations. Veuillez recommencer.",
            ], 401);
        }
    }

    public function updatePresentation(Request $request, $id)
    {
        $utilisateur = UsersApp::findOrFail($id);

        $rules = [
            'presentation' => 'sometimes|required|string',
        ];

        $messages = [
            'presentation.required' => 'Veuillez vous presenter.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => collect($validator->errors()->all()),
            ], 422);
        }

        // Mise à jour des champs modifiables
        if ($request->filled('presentation')) {
            $utilisateur->presentation = $request->presentation;
        }

        if ($utilisateur->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Informations mises à jour avec succès',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Impossible de mettre à jour vos informations. Veuillez recommencer.",
            ], 401);
        }
    }

    public function presentation($id)
    {
        $utilisateur = UsersApp::findOrFail($id);

        if ($utilisateur) {
            return response()->json([
                'success' => true,
                'message' => 'Données récupérées avec succès',
                'data' => $utilisateur->presentation ?? ''
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Impossible de mettre à jour vos informations. Veuillez recommencer.",
            ], 401);
        }
    }

    public function specialites()
    {
        $specialites = Specialites::select('id_specialite', 'libelle')->get();

        if ($specialites) {
            return response()->json([
                'success' => true,
                'message' => 'Données récupérées avec succès',
                'data' => $specialites
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Impossible de mettre à jour vos informations. Veuillez recommencer.",
            ], 401);
        }
    }

    public function langues()
    {
        $langues = Langues::select('id_langue', 'libelle')->get();

        if ($langues) {
            return response()->json([
                'success' => true,
                'message' => 'Données récupérées avec succès',
                'data' => $langues
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Impossible de mettre à jour vos informations. Veuillez recommencer.",
            ], 401);
        }
    }

    public function assoSpecialite($id)
    {
        $specialites = Specialites::query()
            ->leftJoin('users_app_specialites as uas', function ($join) use ($id) {
                $join->on('specialites.id_specialite', '=', 'uas.id_speciale')
                    ->where('uas.id_utilisateur', '=', $id);
            })
            ->select(
                'specialites.id_specialite',
                'specialites.libelle',
                DB::raw('CASE WHEN uas.id_utilisateur IS NOT NULL THEN 1 ELSE 0 END AS is_associe')
            )
            ->orderBy('specialites.libelle', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Liste des spécialités de l’utilisateur',
            'data' => $specialites
        ]);
    }

    public function assoLangue($id)
    {
        $langues = Langues::query()
            ->leftJoin('users_app_langues_parlees as uas', function ($join) use ($id) {
                $join->on('langues.id_langue', '=', 'uas.id_language')
                    ->where('uas.id_utilisateur', '=', $id);
            })
            ->select(
                'langues.id_langue',
                'langues.libelle',
                DB::raw('CASE WHEN uas.id_utilisateur IS NOT NULL THEN 1 ELSE 0 END AS is_associe')
            )
            ->orderBy('langues.libelle', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Liste des langues de l’utilisateur',
            'data' => $langues
        ]);
    }

    public function associerSpecialitesUtilisateur(Request $request)
    {
        $rules = [
            'id_utilisateur' => 'required|integer|exists:users_app,id_user_app',
            'specialites' => 'required|array',
            'specialites.*' => 'integer|exists:specialites,id_specialite',
        ];

        $messages = [
            'id_utilisateur.required' => 'L’identifiant de l’utilisateur est requis.',
            'id_utilisateur.integer' => 'L’identifiant de l’utilisateur doit être un nombre.',
            'id_utilisateur.exists' => 'L’utilisateur spécifié est introuvable.',
            'specialites.required' => 'Veuillez sélectionner au moins une spécialité.',
            'specialites.array' => 'Le format des spécialités est invalide.',
            'specialites.*.integer' => 'Chaque spécialité doit être un nombre.',
            'specialites.*.exists' => 'Certaines spécialités sélectionnées sont invalides.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => collect($validator->errors()->all()),
            ], 422);
        }

        // ✅ Si la validation passe
        $id_utilisateur = $request->id_utilisateur;
        $specialites = $request->specialites;

        DB::beginTransaction();

        try {
            // 1️⃣ Supprimer toutes les associations existantes
            DB::table('users_app_specialites')
                ->where('id_utilisateur', $id_utilisateur)
                ->delete();

            // 2️⃣ Préparer les nouvelles lignes
            $inserts = [];
            foreach ($specialites as $id_specialite) {
                $inserts[] = [
                    'id_utilisateur' => $id_utilisateur,
                    'id_speciale' => $id_specialite,
                ];
            }

            // 3️⃣ Insérer les nouvelles associations
            DB::table('users_app_specialites')->insert($inserts);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Vos spécialités ont été mises à jour avec succès',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de l’association des spécialités',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function associerLanguesUtilisateur(Request $request)
    {
        $rules = [
            'id_utilisateur' => 'required|integer|exists:users_app,id_user_app',
            'langues' => 'required|array',
            'langues.*' => 'integer|exists:langues,id_langue',
        ];

        $messages = [
            'id_utilisateur.required' => 'L’identifiant de l’utilisateur est requis.',
            'id_utilisateur.integer' => 'L’identifiant de l’utilisateur doit être un nombre.',
            'id_utilisateur.exists' => 'L’utilisateur spécifié est introuvable.',
            'langues.required' => 'Veuillez sélectionner au moins une langue.',
            'langues.array' => 'Le format des langues est invalide.',
            'langues.*.integer' => 'Chaque langue doit être un nombre.',
            'langues.*.exists' => 'Certaines langues sélectionnées sont invalides.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => collect($validator->errors()->all()),
            ], 422);
        }

        // ✅ Si la validation passe
        $id_utilisateur = $request->id_utilisateur;
        $langues = $request->langues;

        DB::beginTransaction();

        try {
            // 1️⃣ Supprimer toutes les associations existantes
            DB::table('users_app_langues_parlees')
                ->where('id_utilisateur', $id_utilisateur)
                ->delete();

            // 2️⃣ Préparer les nouvelles lignes
            $inserts = [];
            foreach ($langues as $id_langue) {
                $inserts[] = [
                    'id_utilisateur' => $id_utilisateur,
                    'id_language' => $id_langue,
                ];
            }

            // 3️⃣ Insérer les nouvelles associations
            DB::table('users_app_langues_parlees')->insert($inserts);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Vos langues ont été mises à jour avec succès',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de l’association des langues',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getDisponibilitesByUser($id)
    {
        $disponibilites = Disponibilites::with(['jour', 'heure'])
            ->where('id_utilisateur', $id)
            ->get()
            ->groupBy('jour.libelle')
            ->map(function ($items, $jour) {
                return [
                    'jour' => $jour,
                    'heures' => $items->map(function ($item) {
                        return $item->heure->libelle;
                    })->values(),
                ];
            })
            ->values();

        return response()->json($disponibilites);
    }

    /**
     * Enregistrer ou mettre à jour les disponibilités d’un utilisateur
     */
    public function saveDisponibilites(Request $request)
    {
        $rules = [
            'id_utilisateur' => 'required|integer',
            'disponibilites' => 'required|array',
            'disponibilites.*.id_day' => 'required|integer|exists:jours,id_jour',
            'disponibilites.*.id_time' => 'required|integer|exists:heures,id_heure',
        ];

        $messages = [
            'id_utilisateur.required' => 'Veuillez préciser l’utilisateur.',
            'disponibilites.required' => 'Les disponibilités sont requises.',
            'disponibilites.*.id_day.required' => 'Le jour est requis.',
            'disponibilites.*.id_time.required' => 'L’heure est requise.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => collect($validator->errors()->all()),
            ], 422);
        }

        // Supprimer les anciennes disponibilités
        Disponibilites::where('id_utilisateur', $request->id_utilisateur)->delete();

        // Insérer les nouvelles
        foreach ($request->disponibilites as $dispo) {
            Disponibilites::create([
                'id_day' => $dispo['id_day'],
                'id_time' => $dispo['id_time'],
                'id_utilisateur' => $request->id_utilisateur,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Disponibilités mises à jour avec succès.',
        ]);
    }

    public function getJoursEtHeures()
    {
        // Récupération des jours et heures
        $jours = Jours::orderBy('id_jour', 'asc')->get();
        $heures = Heures::orderBy('id_heure', 'asc')->get();

        // Construction du tableau final
        $result = $jours->map(function ($jour) use ($heures) {
            return [
                'jour' => $jour->libelle,
                'heures' => $heures->map(function ($heure) {
                    return [
                        'id_heure' => $heure->id_heure,
                        'libelle' => trim($heure->libelle), // pour éviter les espaces
                    ];
                })->values()
            ];
        })->values();

        // Réponse JSON
        return response()->json($result);
    }
}
