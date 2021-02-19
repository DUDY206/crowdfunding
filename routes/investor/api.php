<?php

use App\Http\Controllers\Admin\CompanyInvestController;
use Illuminate\Support\Facades\Route;
Route::apiResource('/company-invest', CompanyInvestController::class);
Route::get('/company-invest/{slug}/{locale}', [CompanyInvestController::class,'getCompanyInvestBySlug'])->name('company-invest.getBySlug');
