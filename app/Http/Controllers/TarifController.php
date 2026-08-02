<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TarifController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->intended('index');
        }

        $commissionDefaut = DB::table('parametres')->where('cle', 'commission_defaut')->value('valeur') ?? 15;
        $fraisAnnulation  = DB::table('parametres')->where('cle', 'frais_annulation')->value('valeur') ?? 0;

        // Tarification moyenne par spécialité (vue d'ensemble du marché)
        $tarifsParSpecialite = DB::table('services')
            ->join('specialites', 'services.id_speciale', '=', 'specialites.id_specialite')
            ->select(
                'specialites.id_specialite',
                'specialites.libelle',
                DB::raw('COUNT(services.id_service) as nb_offres'),
                DB::raw('AVG(services.prix) as prix_moyen'),
                DB::raw('MIN(services.prix) as prix_min'),
                DB::raw('MAX(services.prix) as prix_max'),
                DB::raw('AVG(services.commission) as commission_moyenne')
            )
            ->groupBy('specialites.id_specialite', 'specialites.libelle')
            ->orderBy('specialites.libelle')
            ->get();

        return view('tarifs.tarifs', compact('commissionDefaut', 'fraisAnnulation', 'tarifsParSpecialite'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'commission_defaut' => 'required|numeric|min:0|max:100',
            'frais_annulation'  => 'required|numeric|min:0|max:100',
        ], [
            'commission_defaut.required' => 'Veuillez indiquer la commission par défaut.',
            'commission_defaut.numeric'  => 'La commission doit être un nombre.',
            'commission_defaut.max'      => 'La commission ne peut pas dépasser 100%.',
        ]);

        DB::table('parametres')->updateOrInsert(
            ['cle' => 'commission_defaut'],
            ['valeur' => $request->commission_defaut, 'updated_at' => now()]
        );

        DB::table('parametres')->updateOrInsert(
            ['cle' => 'frais_annulation'],
            ['valeur' => $request->frais_annulation, 'updated_at' => now()]
        );

        return back()->with('succes', 'Les paramètres de tarification ont été mis à jour.');
    }
}
