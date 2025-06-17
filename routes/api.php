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
Route::apiResource('administrateurs', AdministrateurController::class);
Route::middleware('auth:admin_api')->group(function () {
    Route::post('profils', [ProfilController::class, 'store']);
});
Route::middleware('auth:admin_api')->group(function () {
    Route::post('commentaires', [CommentaireController::class, 'store']);
});
