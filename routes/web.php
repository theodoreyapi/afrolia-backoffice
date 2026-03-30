<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ConfigTarifController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\HairController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\PolitiqueController;
use App\Http\Controllers\RemboursementController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\UtilisateursController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('index', [CustomAuthController::class, 'dashboard']);
Route::post('custom-login', [CustomAuthController::class, 'customLogin']);
Route::get('logout', [CustomAuthController::class, 'signOut'])->name('logout');

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->intended('index');
    }
    return view('auth.sign-in');
});

// Authentification
Route::get('sign-up', function () {
    return view('auth.sign-up');
});
Route::get('sign-up', function () {
    return view('auth.sign-up');
});
Route::get('forgot', function () {
    return view('auth.forgot-password');
});

// utilisateurs
Route::resource('users', UtilisateursController::class);
Route::resource('hair', HairController::class);
Route::resource('evenement', ReservationController::class);
Route::get('user-add', function () {
    return view('users.add-user');
});
Route::get('view-profile', function () {
    return view('users.view-profile');
});
Route::get('conditions', function () {
    return view('conditions.condition');
});
//{{ url()->previous() }}
// rapports
Route::get('transaction', function () {
    return view('layouts.master');
});
Route::get('abonnement', function () {
    return view('layouts.master');
});
Route::get('utilisateur', function () {
    return view('layouts.master');
});
Route::get('pharmacies', function () {
    return view('layouts.master');
});

// Finance
Route::resource('publicite', PaiementController::class);
Route::resource('remboursement', RemboursementController::class);
Route::resource('tarifs', ConfigTarifController::class);

// termes
Route::resource('terms-condition', TermsController::class);
Route::resource('terms-politique', PolitiqueController::class);
Route::resource('terms-about', AboutController::class);
Route::post('/admin/termes-conditions', [TermsController::class, 'enregistrerOuMettreAJour'])->name('termes.storeOrUpdate');
Route::post('/admin/termes-politique', [PolitiqueController::class, 'enregistrerOuMettreAJour'])->name('termes.storeOrPolitique');
Route::post('/admin/termes-about', [AboutController::class, 'enregistrerOuMettreAJour'])->name('termes.storeOrAbout');

// setting
Route::get('notification', function () {
    return view('layouts.master');
});
Route::get('notification-alert', function () {
    return view('layouts.master');
});
Route::get('payment-gateway', function () {
    return view('layouts.master');
});
Route::get('siteweb', function () {
    return view('welcome');
});
Route::resource('company', CompanyController::class);
