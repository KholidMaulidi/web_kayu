<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\BondedWoodController;
use App\Http\Controllers\Api\NonBondedWoodController;
use App\Http\Controllers\Api\TypeWoodController;
use App\Http\Controllers\Api\WoodController;

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [RegisterController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('bonded-woods/{id}', [BondedWoodController::class, 'update']); 
    Route::apiResource('bonded-woods', BondedWoodController::class);

    // NonBondedWood
    Route::post('non-bonded-woods/{id}', [NonBondedWoodController::class, 'update']); 
    Route::apiResource('non-bonded-woods', NonBondedWoodController::class);

    // TypeWood
    Route::get('type-woods', [TypeWoodController::class, 'index']); 
    Route::post('type-woods', [TypeWoodController::class, 'store']);
    Route::get('type-woods/{id}', [TypeWoodController::class, 'show']); 
    Route::put('type-woods/{id}', [TypeWoodController::class, 'update']); 
    Route::delete('type-woods/{id}', [TypeWoodController::class, 'delete']);

    // Wood
    
    Route::apiResource('woods', WoodController::class);

    Route::post('logout', [LogoutController::class, 'logout']);
});
