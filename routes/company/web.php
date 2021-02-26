<?php

use App\Http\Controllers\Company\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('{path}', HomeController::class)->where('path', '(.*)');
