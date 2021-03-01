<?php


use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CompanyInvestController;
use App\Http\Controllers\Admin\FAQRiskController;
use App\Http\Controllers\Admin\UserInfoController;
use App\Http\Controllers\UploadImageController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/company', CompanyController::class);
Route::get('/company-all', [CompanyController::class,'index_not_paging']);

Route::apiResource('/company-invest', CompanyInvestController::class);
Route::apiResource('/company-invest-faq', FAQRiskController::class);
Route::apiResource('/user-info', UserInfoController::class);

Route::get('upload_image', [UploadImageController::class,'index']);
Route::post('upload_image', [UploadImageController::class,'store'])->name('upload_image');
