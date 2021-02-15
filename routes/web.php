<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    dd("hello world");
    return view('welcome');
});

Route::get("/test", function () {
    dd("Testing interface");
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('accountCategories', App\Http\Controllers\AccountCategoryController::class);

    Route::resource('accountHeads', App\Http\Controllers\AccountHeadController::class);

    Route::resource('orgAccountCategories', App\Http\Controllers\OrgAccountCategoryController::class);

    Route::resource('orgAccountHeads', App\Http\Controllers\OrgAccountHeadController::class);

    Route::resource('countries', App\Http\Controllers\CountryController::class);

    Route::resource('banks', App\Http\Controllers\BankController::class);

    Route::resource('orgBankAccounts', App\Http\Controllers\OrgBankAccountController::class);

    Route::resource('paymentVouchers', App\Http\Controllers\PaymentVoucherController::class);
    Route::get('/paymentVouchers/{id}/details', 'App\Http\Controllers\PaymentVoucherController@printPV');

    Route::resource('paymentVoucherDetails', App\Http\Controllers\PaymentVoucherDetailsController::class);

    Route::resource('payments', App\Http\Controllers\PaymentController::class);

    Route::get('/income/create', 'App\Http\Controllers\PaymentController@showCreateIncome');
    Route::post('/income/create', 'App\Http\Controllers\PaymentController@createIncome');
    Route::get('/income/{id}/receipt', 'App\Http\Controllers\PaymentController@showReceipt');

    Route::post('/jv/create', 'App\Http\Controllers\PaymentController@createJV');

    Route::resource('transactions', App\Http\Controllers\TransactionController::class);

    Route::resource('configurations', App\Http\Controllers\ConfigurationController::class);

    Route::resource('companies', App\Http\Controllers\CompanyController::class);

    Route::resource('users', App\Http\Controllers\UserController::class);

    Route::resource('staff', App\Http\Controllers\StaffController::class);

    Route::resource('receipts', App\Http\Controllers\ReceiptController::class);

    Route::resource('journalVouchers', App\Http\Controllers\JournalVoucherController::class);
    Route::get('/jv/{id}/summary', 'App\Http\Controllers\JournalVoucherController@printJV');

    Route::group(['prefix' => 'reprints'], function () {
        Route::get('/pv', 'App\Http\Controllers\PaymentVoucherController@showReprintPV');
        Route::post('/pv', 'App\Http\Controllers\PaymentVoucherController@reprintPV');

        Route::get('/receipt', 'App\Http\Controllers\ReceiptController@showReprintReceipt');
        Route::post('/receipt', 'App\Http\Controllers\ReceiptController@reprintReceipt');

        Route::get('/jv', 'App\Http\Controllers\JournalVoucherController@showReprintJV');
        Route::post('/jv', 'App\Http\Controllers\JournalVoucherController@reprintJV');
    });

    Route::group(['prefix' => 'reverse'], function () {
        Route::get('/receipt', 'App\Http\Controllers\ReceiptController@showReverseReceipt');
        Route::post('/receipt', 'App\Http\Controllers\ReceiptController@reverseReceipt');

        Route::get('/payment', 'App\Http\Controllers\PaymentController@showReversePayment');
        Route::post('/payment', 'App\Http\Controllers\PaymentController@reversePayment');
    });

    Route::group(['prefix' => 'reports'], function () {
        Route::get('/general-ledger', 'App\Http\Controllers\AccountReport@showGeneralLedger');
        Route::post('/general-ledger', 'App\Http\Controllers\AccountReport@generalLedger');
    });
});
