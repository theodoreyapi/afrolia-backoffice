<?php

use App\Http\Controllers\Api\ApiSecurityController;
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
