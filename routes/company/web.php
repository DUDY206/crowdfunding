<?php
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('company.dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
