<?php

namespace App\Http\Controllers;

use App\Models\UsersApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UtilisateursController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->intended('index');
        }

        $users = UsersApp::where('role', 'user')->get();
        return view('users.users-list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $roles = [
            'libelle' => 'required|unique:categories,libelle_categorie',
            'illustre' => 'required',
        ];
        $customMessages = [
            'libelle.unique' => $request->libelle . " existe déjà. Veuillez essayer une autre.",
            'libelle.required' => "Veuillez saisir le libelle de la catégorie.",
            'illustre.required' => "Veuillez saisir l'icone de la catégorie.",
        ];

        $request->validate($roles, $customMessages);

        $porte = new Categories();
        $porte->icon_categorie = $request->illustre;
        $porte->libelle_categorie = $request->libelle;
        if ($porte->save()) {
            return back()->with('succes',  "Vous avez ajouter " . $request->libelle);
        } else {
            return back()->withErrors(["Impossible d'ajouter " . $request->libelle . ". Veuillez réessayer!!"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $porte = Categories::findOrFail($id);

        $roles = [
            'libelle' => 'required',
            'illustre' => 'required',
        ];
        $customMessages = [
            'libelle.required' => "Veuillez saisir le libelle de la catégorie.",
            'illustre.required' => "Veuillez saisir l'icone de la catégorie.",
        ];

        $request->validate($roles, $customMessages);

        if ($porte->libelle_categorie !== $request->libelle) {
            $porte->libelle_categorie = $request->libelle;
        }
        if ($porte->statut_categorie !== $request->statut) {
            $porte->statut_categorie = $request->statut;
        }

        $porte->icon_categorie = $request->illustre;

        if ($porte->save()) {
            return back()->with('succes', "Vous avez modifier avec succès.");
        } else {
            return back()->withErrors(["Problème lors de la modification. Veuillez réessayer!!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Categories::findOrFail($id)->delete();

        return back()->with('succes', "La suppression a été effectué");
    }
}
