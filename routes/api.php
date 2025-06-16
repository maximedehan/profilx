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
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResource('administrateurs', AdministrateurController::class);
Route::apiResource('profils', ProfilController::class);
Route::apiResource('commentaires', CommentaireController::class);
