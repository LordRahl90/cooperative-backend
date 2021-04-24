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
Route::get('/countries/{code}/states', 'CountryAPIController@loadState');

Route::resource('banks', App\Http\Controllers\API\BankAPIController::class);

Route::resource('org_bank_accounts', App\Http\Controllers\API\OrgBankAccountAPIController::class);

Route::resource('payment_vouchers', 'PaymentVoucherAPIController');
Route::get('payment_vouchers/{id}/details', 'PaymentVoucherAPIController@loadPVDetails');

Route::resource('payment_voucher_details', App\Http\Controllers\API\PaymentVoucherDetailsAPIController::class);

Route::resource('payments', App\Http\Controllers\API\PaymentAPIController::class);
Route::post("/payments/jv", 'PaymentAPIController@postJournalVoucher');

Route::resource('transactions', App\Http\Controllers\API\TransactionAPIController::class);

Route::resource('configurations', App\Http\Controllers\API\ConfigurationAPIController::class);

Route::resource('companies', App\Http\Controllers\API\CompanyAPIController::class);
Route::get('companies/{id}/account-heads', 'CompanyAPIController@accountHeads');

Route::resource('users', App\Http\Controllers\API\UserAPIController::class);


Route::resource('staff', App\Http\Controllers\API\StaffAPIController::class);


Route::resource('receipts', App\Http\Controllers\API\ReceiptAPIController::class);


Route::resource('journal_vouchers', App\Http\Controllers\API\JournalVoucherAPIController::class);

Route::resource('customers', App\Http\Controllers\API\CustomerAPIController::class);
Route::get('/customer-loans/{id}', 'CustomerAPIController@customerLoans');
Route::get('/customer-loans/{loanID}/details', 'CustomerAPIController@loadLoanDetails');
Route::get('/customer-savings/{id}', 'CustomerAPIController@customerSavings');
Route::get('/customer-savings/{savingsId}/balance', 'CustomerAPIController@savingsBalance');

Route::resource('customer_addresses', App\Http\Controllers\API\CustomerAddressAPIController::class);

Route::resource('customer_next_of_kins', App\Http\Controllers\API\CustomerNextOfKinAPIController::class);

Route::resource('savings_categories', App\Http\Controllers\API\SavingsCategoryAPIController::class);
Route::get('/savings-categories/{id}/accounts', 'SavingsCategoryAPIController@loadCategoryAccount');

Route::resource('loan_categories', App\Http\Controllers\API\LoanCategoryAPIController::class);
Route::get('/loan-categories/{id}/accounts', 'LoanCategoryAPIController@loadCategoryAccount');

Route::resource('savings_accounts', App\Http\Controllers\API\SavingsAccountAPIController::class);

Route::resource('loan_accounts', App\Http\Controllers\API\LoanAccountAPIController::class);

Route::resource('customer_savings', App\Http\Controllers\API\CustomerSavingAPIController::class);

Route::resource('loan_applications', App\Http\Controllers\API\LoanApplicationAPIController::class);

Route::resource('customer_loans', App\Http\Controllers\API\CustomerLoanAPIController::class);

Route::resource('loan_repayments', App\Http\Controllers\API\LoanRepaymentAPIController::class);

Route::resource('customer_transactions', App\Http\Controllers\API\CustomerTransactionAPIController::class);

Route::resource('states', App\Http\Controllers\API\StateAPIController::class);

Route::resource('customer_bank_accounts', App\Http\Controllers\API\CustomerBankAccountAPIController::class);


Route::resource('customer_loan_logs', App\Http\Controllers\API\CustomerLoanLogAPIController::class);


Route::resource('loan_guarators', App\Http\Controllers\API\LoanGuaratorAPIController::class);


Route::resource('fee_managements', App\Http\Controllers\API\FeeManagementAPIController::class);