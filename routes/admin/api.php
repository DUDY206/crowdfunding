<?php

use App\Http\Controllers\Admin\CompanyController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/company', CompanyController::class);
