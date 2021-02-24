<?php

use App\Http\Controllers\Investor\CompanyInvestController;
use App\Http\Controllers\Investor\AccountLikeModelController;
use App\Http\Controllers\Investor\SocialCommentController;
use App\Http\Controllers\Investor\UserInfoController;
use Illuminate\Support\Facades\Route;
Route::apiResource('/company-invest', CompanyInvestController::class);
Route::apiResource('/social-comment', SocialCommentController::class);
Route::apiResource('/user-info', UserInfoController::class)->only(['update']);
Route::get('/user-info-slug/{slug}', [UserInfoController::class,'getUserBySlug']);
Route::post('/account-like-model', [AccountLikeModelController::class,'store']);
Route::get('/company-invest/{slug}/{locale}', [CompanyInvestController::class,'getCompanyInvestBySlug'])->name('company-invest.getBySlug');
