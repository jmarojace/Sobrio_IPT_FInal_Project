<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\BreedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FarmController;
use App\Http\Controllers\FeedingRecordController;
use App\Http\Controllers\VaccinationController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');
Route::resource('farms', FarmController::class);
Route::resource('breeds', BreedController::class);
Route::resource('animals', AnimalController::class);
Route::resource('vaccinations', VaccinationController::class);
Route::resource('feeding-records', FeedingRecordController::class);
