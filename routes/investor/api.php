<?php

use App\Http\Controllers\Admin\InvestContractFieldController;
use App\Http\Controllers\Admin\InvestHasTypeController;
use App\Http\Controllers\Investor\CompanyInvestController;
use App\Http\Controllers\Investor\AccountLikeModelController;
use App\Http\Controllers\Investor\ContractController;
use App\Http\Controllers\Investor\OrderController;
use App\Http\Controllers\Investor\SocialCommentController;
use App\Http\Controllers\Investor\UserInfoController;
use App\Http\Controllers\Investor\VNPay\CreatePayment;
use App\Http\Controllers\Investor\VNPay\VNPayReturn;
use App\Http\Controllers\Investor\VNPay\VNPayIpn;
use Illuminate\Support\Facades\Route;

Route::apiResource('/company-invest', CompanyInvestController::class);
Route::apiResource('/social-comment', SocialCommentController::class);
Route::apiResource('/user-info', UserInfoController::class)->only(['update']);
Route::apiResource('/invest-has-type', InvestHasTypeController::class)->only(['show']);
Route::get('/user-info-slug/{slug}', [UserInfoController::class,'getUserBySlug']);
Route::post('/account-like-model', [AccountLikeModelController::class,'store']);
Route::post('/get-account-like/{status}', [AccountLikeModelController::class,'like']);
Route::post('/get-account-be-like/{status}', [AccountLikeModelController::class,'beliked']);
Route::get('/company-invest/{slug}/{locale}', [CompanyInvestController::class,'getCompanyInvestBySlug'])->name('company-invest.getBySlug');
Route::get('/company-invest-of/{slug}/{locale}', [CompanyInvestController::class,'getCompanyInvestByUser'])->name('company-invest-of.getByUser');
Route::get('/company-invest/{slug}/contract/{invest_type_id}/{locale}', [ContractController::class,'index'])->name('get-company-invest-contract');
Route::apiResource('/invest-contract-field', InvestContractFieldController::class)->only(['show']);
Route::apiResource('/order', OrderController::class);
Route::post('/payment/vnpay/create-payment',[CreatePayment::class,'index']);
Route::get('payment/vnpay/success-payment', [VNPayReturn::class,'index'])->name('payment.vnpay.return');
Route::get('payment/vnpay/ipn', [VNPayIpn::class,'index'])->name('payment.vnpay.ipn');
