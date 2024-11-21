<?php

use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('mahasiswa', [MahasiswaController::class, 'index']);
// Route::get('mahasiswa/create', [MahasiswaController::class, 'create']);


Route::resource('mahasiswa', MahasiswaController::class);