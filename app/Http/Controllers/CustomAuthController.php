<?php

namespace App\Http\Controllers;

use App\Models\Gains;
use App\Models\Reservations;
use App\Models\User;
use App\Models\UsersApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomAuthController extends Controller
{
    public function index()
    {
        return view('auth.sign-in');
    }

    public function customLogin(Request $request)
    {
        $roles = [
            'email' => 'required',
            'password' => 'required',
        ];
        $customMessages = [
            'email.required' => "Veuillez saisir votre adresse email.",
            'password.required' => "Veuillez saisir votre mot de passe.",
        ];

        $request->validate($roles, $customMessages);

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            return redirect()->intended('index');
        } else {
            return back()->withErrors(['E-mail ou mot de passe incorrect.']);
        }
    }

    public function dashboard()
    {
        if (Auth::check()) {

            $client = UsersApp::where('role', '=', 'user')->count();
            $hair = UsersApp::where('role', '=', 'hair')->count();
            $reservationTerminee = Reservations::where('statut', '=', 'terminee')->count();
            $reservationEncours = Reservations::where('statut', '=', 'en_attente')->count();
            $total = Gains::sum('montant_brut');
            $commission = Gains::sum('montant_commission');
            $coiffeuse = Gains::sum('montant_net');
            $attente = Gains::where('statut', '=', 'en_attente')->sum('montant_net');

            return view('home.index', compact('client', 'hair', 'reservationTerminee', 'reservationEncours', 'total', 'commission', 'coiffeuse', 'attente'));
        } else {
            return view('auth.sign-in');
        }
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();
        return Redirect('/');
    }
}
