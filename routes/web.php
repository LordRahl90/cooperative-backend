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


//Route::domain('{account}.' . env('APP_URL', 'coop-account.test'))->group(function () {
Route::group(['domain' => '{account}.' . env('APP_URL', 'coop-account.test'), 'middleware' => 'domain'], function () {
    Route::resource('users', App\Http\Controllers\UserController::class);
//    Route::get('/custom', function ($account) {
//        dd($account);
//    });

    Route::get('/', function ($account) {
        return view('welcome');
    });

    Route::get('/staff/activate');

    Route::get('/custom', function () {
        Log::info("hello world");
        $company = \App\Models\Company::find(1);
        $staff = \App\Models\Staff::find(2);
//    dd('Loan repayment for ' . Date('M, Y'));
//        $path = "app/schedules/cus-606b3083c34d1.xlsx";
//        \App\Jobs\ProcessRepaymentSchedule::dispatch(1, 36, 14, $path, "2021-03")->onQueue('repayment');
//    \Illuminate\Support\Facades\Log::info($staff);
    \Illuminate\Support\Facades\Mail::to("tolaabbey001@hotmail.com")->queue(new \App\Mail\NewStaffRegistered($company, $staff, "password"));
    dump("Mail sent successfully,");
//        dump("All good");
        response()->json(['success' => true, 'message' => 'all good']);
    });

//    Auth::routes();

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

        Route::resource('orgAccountCategories', App\Http\Controllers\OrgAccountCategoryController::class);

        Route::resource('orgAccountHeads', App\Http\Controllers\OrgAccountHeadController::class);

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

            Route::get('/bank-report', 'App\Http\Controllers\AccountReport@showBankReport');
            Route::post('/bank-report', 'App\Http\Controllers\AccountReport@bankReport');

            Route::get('/trial-balance', 'App\Http\Controllers\AccountReport@showTrialBalance');
            Route::post('/trial-balance', 'App\Http\Controllers\AccountReport@trialBalance');

        });

        Route::resource('customers', App\Http\Controllers\CustomerController::class);
        Route::resource('members', App\Http\Controllers\CustomerController::class);
        Route::get('/customer/upload', 'App\Http\Controllers\CustomerController@showUpload');
        Route::post('/customer/upload', 'App\Http\Controllers\CustomerController@upload');

        Route::resource('customerAddresses', App\Http\Controllers\CustomerAddressController::class);

        Route::resource('customerNextOfKins', App\Http\Controllers\CustomerNextOfKinController::class);

        Route::resource('savingsCategories', App\Http\Controllers\SavingsCategoryController::class);

        Route::resource('loanCategories', App\Http\Controllers\LoanCategoryController::class);

        Route::resource('savingsAccounts', App\Http\Controllers\SavingsAccountController::class);

        Route::resource('loanAccounts', App\Http\Controllers\LoanAccountController::class);

        Route::resource('customerSavings', App\Http\Controllers\CustomerSavingController::class);

        Route::get('/customer-savings/payment', 'App\Http\Controllers\CustomerSavingController@showSavingsPayment');
        Route::post('/customer-savings/payment', 'App\Http\Controllers\CustomerSavingController@makeSavingsPayment');

        Route::resource('loanApplications', App\Http\Controllers\LoanApplicationController::class);

        Route::resource('customerLoans', App\Http\Controllers\CustomerLoanController::class);

        Route::resource('loanRepayments', App\Http\Controllers\LoanRepaymentController::class);
        Route::get('/repayment/schedule', 'App\Http\Controllers\LoanRepaymentController@showRepaymentSchedule');
        Route::post('/repayment/schedule', 'App\Http\Controllers\LoanRepaymentController@repaymentSchedule');
        Route::get('/repayment/upload', 'App\Http\Controllers\LoanRepaymentController@showUploadRepayment');
        Route::post('/repayment/upload', 'App\Http\Controllers\LoanRepaymentController@uploadRepayment');

        Route::resource('customerTransactions', App\Http\Controllers\CustomerTransactionController::class);

        Route::resource('states', App\Http\Controllers\StateController::class);

        Route::resource('customerBankAccounts', App\Http\Controllers\CustomerBankAccountController::class);
    });

    Route::resource('customerLoanLogs', App\Http\Controllers\CustomerLoanLogController::class);

    Route::resource('loanGuarators', App\Http\Controllers\LoanGuaratorController::class);
});


Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::resource('accountCategories', App\Http\Controllers\AccountCategoryController::class);

    Route::resource('accountHeads', App\Http\Controllers\AccountHeadController::class);

    Route::resource('countries', App\Http\Controllers\CountryController::class);

    Route::resource('banks', App\Http\Controllers\BankController::class);

    Route::resource('companies', App\Http\Controllers\CompanyController::class);

    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('staff', App\Http\Controllers\StaffController::class);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
