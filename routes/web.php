<?php

use App\Http\Controllers\{HomeController,DashboardController};
use App\Http\Controllers\Band\BandController;
use Illuminate\Support\Facades\{Route, Auth};

Auth::routes();

Route::get('/', HomeController::class)->name('home');

Route::get('dashboard', DashboardController::class)->name('dashboard');
Route::middleware('auth')->group(function(){
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::prefix('bands')->group(function(){
        Route::get('create', [BandController::class,'create'])->name('bands.create');
        Route::post('create', [BandController::class,'store']);
    });
});
