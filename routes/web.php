<?php

use App\Http\Controllers\PexesoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PexesoController::class, 'index'])->name('pexeso.index');
Route::get('/update_image', [PexesoController::class, 'showUpdateImageForm'])->name('update.image.form');
Route::post('/update_image', [PexesoController::class, 'updateImage'])->name('update.image');
