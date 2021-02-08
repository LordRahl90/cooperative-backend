<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('account_categories', App\Http\Controllers\API\AccountCategoryAPIController::class);

Route::resource('account_heads', App\Http\Controllers\API\AccountHeadAPIController::class);

Route::resource('org_account_categories', App\Http\Controllers\API\OrgAccountCategoryAPIController::class);

Route::resource('org_account_heads', App\Http\Controllers\API\OrgAccountHeadAPIController::class);

Route::resource('countries', App\Http\Controllers\API\CountryAPIController::class);

Route::resource('banks', App\Http\Controllers\API\BankAPIController::class);

Route::resource('org_bank_accounts', App\Http\Controllers\API\OrgBankAccountAPIController::class);





Route::resource('payment_vouchers', App\Http\Controllers\API\PaymentVoucherAPIController::class);

Route::resource('payment_voucher_details', App\Http\Controllers\API\PaymentVoucherDetailsAPIController::class);

Route::resource('payments', App\Http\Controllers\API\PaymentAPIController::class);

Route::resource('transactions', App\Http\Controllers\API\TransactionAPIController::class);