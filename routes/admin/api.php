<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CompanyInvestController;
use App\Http\Controllers\Admin\ContractHasInputFieldController;
use App\Http\Controllers\Admin\ContractInputFieldController;
use App\Http\Controllers\Admin\ContractTemplateController;
use App\Http\Controllers\Admin\FAQRiskController;
use App\Http\Controllers\Admin\InvestContractFieldController;
use App\Http\Controllers\Admin\InvestHasContractFieldController;
use App\Http\Controllers\Admin\InvestHasContractFieldValueController;
use App\Http\Controllers\Admin\InvestHasContractTemplateController;
use App\Http\Controllers\Admin\InvestHasTypeController;
use App\Http\Controllers\Admin\InvestTypeController;
use App\Http\Controllers\Admin\UserInfoController;
use App\Http\Controllers\UploadImageController;
use App\Http\Requests\InvestHasType;
use Illuminate\Support\Facades\Route;

Route::apiResource('/company', CompanyController::class);
Route::apiResource('/company-invest', CompanyInvestController::class);
Route::apiResource('/company-invest-faq', FAQRiskController::class);
Route::apiResource('/manage-admin', AdminController::class);
Route::apiResource('/user-info', UserInfoController::class);
Route::apiResource('/invest-type', InvestTypeController::class)->except('show');
Route::apiResource('/invest-has-type', InvestHasTypeController::class)->only(['store','show']);
Route::apiResource('/contract-input-field', ContractInputFieldController::class);
Route::apiResource('/contract-has-input-field', ContractHasInputFieldController::class)->only(['store','show']);
Route::apiResource('/contract-template', ContractTemplateController::class);
Route::apiResource('/invest-has-contract-template', InvestHasContractTemplateController::class)->only(['store','show']);
Route::apiResource('/invest-has-contract-template', InvestHasContractTemplateController::class)->only(['store','show']);
Route::apiResource('/invest-contract-field', InvestContractFieldController::class);
Route::apiResource('/invest-has-contract-field', InvestHasContractFieldController::class);
Route::apiResource('/invest-contract-field-value', InvestHasContractFieldValueController::class);


Route::get('upload_image', [UploadImageController::class,'index']);
Route::post('upload_image', [UploadImageController::class,'store'])->name('upload_image');
Route::put('update-image-admin/{id}', [AdminController::class,'updateImage'])->name('update-image-admin');

Route::get('search-company-invest', [CompanyInvestController::class, 'search'])->name('search-company-invest');
