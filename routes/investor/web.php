<?php
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('investor.dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
