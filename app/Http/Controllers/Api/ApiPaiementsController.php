<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gains;
use App\Models\Paiements;
use App\Models\Reservations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stripe\PaymentIntent;
use Stripe\Stripe;

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
        $rules = [
            'montant' => 'required|numeric',
            'id_reservation' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => collect($validator->errors()->all())
            ], 422);
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        // 🔵 1 — Créer PaymentIntent
        $intent = PaymentIntent::create([
            'amount' => $request->montant * 100,  // Stripe en centimes
            'currency' => 'xof',
            'payment_method_types' => ['card'],
        ]);

        // 🔵 2 — Enregistrer le paiement (status = pending)
        $paiement = Paiements::create([
            'id_reservation' => $request->id_reservation,
            'payment_intent_id' => $intent->id,
            'amount' => $request->montant,
            'currency' => 'XOF',
            'payment_method' => 'stripe',
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Paiement enregistré avec succès',
            'client_secret' => $intent->client_secret,
            'paiement' => $paiement
        ]);
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

    public function stripeWebhook(Request $request)
    {
        $event = $request->type;

        if ($event === 'payment_intent.succeeded') {

            $intent = $request->data['object'];
            $paymentIntentId = $intent['id'];

            // 🔵 Récupérer le paiement
            $paiement = Paiements::where('payment_intent_id', $paymentIntentId)->first();

            if ($paiement) {
                $paiement->update([
                    'status' => 'succeeded',
                    'processed_at' => now()
                ]);

                // 🔵 Calcul du gain coiffeur
                $reservation = Reservations::find($paiement->id_reservation);

                if ($reservation) {

                    // 🔵 Mettre à jour le statut de paiement de la réservation
                    $reservation->update([
                        'statut_paiement' => 'paye',
                    ]);

                    $montant_brut = $paiement->amount;
                    $montant_net = $montant_brut / 1.15;
                    $commission = $montant_brut - $montant_net;

                    Gains::create([
                        'id_coiffeur' => $reservation->id_coiffeur,
                        'id_reservation' => $reservation->id_reservation,
                        'montant_brut' => $montant_brut,
                        'montant_commission' => $commission,
                        'montant_net' => $montant_net,
                        'statut' => 'en_attente',
                    ]);
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
