<?php

use App\Http\Controllers\PexesoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PexesoController::class, 'index'])->name('pexeso.index');
