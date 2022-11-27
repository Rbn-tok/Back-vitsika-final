<?php

use App\Http\Controllers\AlerteController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\UtilisateurController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Routes Publication
Route::post("creer-publication",[PublicationController::class,"creerPublication"]);
Route::get("afficher-publication",[PublicationController::class,"afficherPublication"]);
Route::post("commenter-publication",[PublicationController::class,"commenterPublication"]);
Route::get("afficher-commentaire",[PublicationController::class,"afficherCommentaire"]);
Route::post("liker-publication",[PublicationController::class,"likerPublication"]);
Route::post("annulerLike-publication",[PublicationController::class,"annulerLikePublication"]);

//Routes alerte et Pollution
Route::post("alerter-pollution",[AlerteController::class,"alerterPollution"]);
Route::get("getAllNiv-alerte",[AlerteController::class,"getAllNivAlerte"]);
Route::get("getAll-pollution",[AlerteController::class,"getAllPollution"]);

// Utilisateur
Route::post('/add-utilisateur',[UtilisateurController::class,'store']);
Route::post('/seConnecter',[UtilisateurController::class,'loginUser']);


Route::get("getPollutionByRegion",[AlerteController::class,"getPollutionByRegion"]);