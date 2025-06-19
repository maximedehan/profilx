<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdministrateurController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\CommentaireController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// CRUD complet pour les administrateurs
Route::apiResource('administrateurs', AdministrateurController::class);

// Seul un admin identifié en BDD peut faire des appels API. 
// Méthodes PROFILS protégées : En création, suppression ou mise à jour
// Méthode COMMENTAIRES protégée : En création seulement
Route::middleware('auth:admin_api')->group(function () {
    Route::post('profils', [ProfilController::class, 'store']);
	Route::put('profils/{profil}', [ProfilController::class, 'update']);
    Route::patch('profils/{profil}', [ProfilController::class, 'update']);
    Route::delete('profils/{profil}', [ProfilController::class, 'destroy']);
	Route::post('commentaires', [CommentaireController::class, 'store']);
});

// Accès libre pour voir les profils et les commentaires
Route::get('profils', [ProfilController::class, 'index']);
Route::get('profils/{profil}', [ProfilController::class, 'show']);
Route::get('commentaires', [CommentaireController::class, 'index']);
Route::get('commentaires/{commentaire}', [CommentaireController::class, 'show']);

// Accès libre pour mettre à jour ou supprimer les commentaires
Route::put('commentaires/{commentaire}', [CommentaireController::class, 'update']);
Route::delete('commentaires/{commentaire}', [CommentaireController::class, 'destroy']);
