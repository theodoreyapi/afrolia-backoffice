<?php

use App\Http\Controllers\Api\ApiSecurityController;
use App\Http\Controllers\Api\ApiServicesController;
use App\Http\Controllers\Api\ApiSociauxController;
use App\Http\Controllers\Api\ApiUserSalonController;
use App\Http\Controllers\Api\ApiUtilisateursController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authentifications
Route::post('login', [ApiUtilisateursController::class, 'login']);
Route::post('register', [ApiUtilisateursController::class, 'register']);
Route::post('otp', [ApiUtilisateursController::class, 'demanderOtpReset']);
Route::post('reset', [ApiUtilisateursController::class, 'resetPasswordWithOtp']);
Route::post('update/{id}', [ApiUtilisateursController::class, 'update']);
Route::delete('delete/{id}', [ApiUtilisateursController::class, 'supprimerCompte']);

// Confidentialite
Route::get('help', [ApiSecurityController::class, 'helps']);
Route::get('security', [ApiSecurityController::class, 'security']);

// Salons
Route::post('update/{id}', [ApiUserSalonController::class, 'update']);
Route::post('updatepresentation/{id}', [ApiUserSalonController::class, 'update']);
Route::get('presentation/{id}', [ApiUserSalonController::class, 'presentation']);
Route::get('specialites', [ApiUserSalonController::class, 'specialites']);
Route::get('langues', [ApiUserSalonController::class, 'langues']);
Route::get('associationspecialite/{id}', [ApiUserSalonController::class, 'assoSpecialite']);
Route::get('associationlangue/{id}', [ApiUserSalonController::class, 'assoLangue']);
Route::post('users/specialites/associer', [ApiUserSalonController::class, 'associerSpecialitesUtilisateur']);
Route::post('users/langues/associer', [ApiUserSalonController::class, 'associerLanguesUtilisateur']);
Route::get('disponibilites/{id}', [ApiUserSalonController::class, 'getDisponibilitesByUser']);
Route::post('disponibilites', [ApiUserSalonController::class, 'saveDisponibilites']);
Route::get('jours-heures', [ApiUserSalonController::class, 'getJoursEtHeures']);
Route::get('users/{id}/services', [ApiServicesController::class, 'getServicesByUser']);
Route::post('users/{id}/services', [ApiServicesController::class, 'createServices']);
Route::put('services/{id}', [ApiServicesController::class, 'updateService']);
Route::delete('services/{id}', [ApiServicesController::class, 'deleteService']);
Route::get('users/{id}/sociaux', [ApiSociauxController::class, 'getSociauxByUser']);
Route::post('users/sociaux', [ApiSociauxController::class, 'saveSociaux']);
Route::get('users/{id}/gallery', [ApiSociauxController::class, 'getGalleryByUser']);
Route::post('users/gallery', [ApiSociauxController::class, 'createGallery']);
Route::put('gallery/{id}', [ApiSociauxController::class, 'updateGallery']);
Route::delete('gallery/{id}', [ApiSociauxController::class, 'deleteGallery']);

