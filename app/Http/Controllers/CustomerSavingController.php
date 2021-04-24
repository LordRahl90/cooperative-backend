<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerSavingRequest;
use App\Http\Requests\UpdateCustomerSavingRequest;
use App\Models\Company;
use App\Models\Customer;
use App\Models\CustomerLoan;
use App\Models\CustomerSaving;
use App\Models\CustomerTransaction;
use App\Models\OrgBankAccount;
use App\Models\PaymentVoucher;
use App\Models\PaymentVoucherDetails;
use App\Models\SavingsAccount;
use App\Repositories\CustomerSavingRepository;
use App\Http\Controllers\AppBaseController;
use App\Utility\Transactions;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Response;

class CustomerSavingController extends AppBaseController
{
    /** @var  CustomerSavingRepository */
    private $customerSavingRepository;

    public function __construct(CustomerSavingRepository $customerSavingRepo)
    {
        $this->customerSavingRepository = $customerSavingRepo;
    }

    /**
     * Display a listing of the CustomerSaving.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request, $account)
    {
        $companyID = session('company_id');
        $customerSavings = $this->customerSavingRepository->where('company_id', $companyID);

        return view('customer_savings.index', ['account' => $account])
            ->with('customerSavings', $customerSavings);
    }

    /**
     * Show the form for creating a new CustomerSaving.
     *
     * @return Response
     */
    public function create($account)
    {
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $companyID = session('company_id');
        $customers = Customer::orderBy('surname', 'asc')->where('company_id', $companyID)->get()->pluck('full_name', 'id');
        $savings = SavingsAccount::orderBy('name', 'asc')->where('company_id', $companyID)->pluck('name', 'id')->toArray();
        return view('customer_savings.create', [
            'companies' => $companies,
            'customers' => $customers,
            'savingsAccount' => $savings,
            'account' => $account
        ]);
    }

    /**
     * Store a newly created CustomerSaving in storage.
     *
     * @param CreateCustomerSavingRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerSavingRequest $request, $account)
    {
        $input = $request->all();

        $customerSaving = $this->customerSavingRepository->create($input);

        Flash::success('Customer Saving saved successfully.');

        return redirect(route('customerSavings.index', $account));
    }

    /**
     * Display the specified CustomerSaving.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($account, $id)
    {
        $customerSaving = $this->customerSavingRepository->find($id);

        if (empty($customerSaving)) {
            Flash::error('Customer Saving not found');

            return redirect(route('customerSavings.index', $account));
        }

        return view('customer_savings.show', ['account' => $account])->with('customerSaving', $customerSaving);
    }

    /**
     * Show the form for editing the specified CustomerSaving.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($account, $id)
    {
        $customerSaving = $this->customerSavingRepository->find($id);
        if (empty($customerSaving)) {
            Flash::error('Customer Saving not found');

            return redirect(route('customerSavings.index', $account));
        }
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $companyID = session('company_id');
        $customers = Customer::orderBy('surname', 'asc')->where('company_id', $companyID)->get()->pluck('full_name', 'id');
        $savings = SavingsAccount::orderBy('name', 'asc')->where('company_id', $companyID)->pluck('name', 'id')->toArray();

        return view('customer_savings.edit', [
            'companies' => $companies,
            'customers' => $customers,
            'savingsAccount' => $savings,
            'account' => $account
        ])->with('customerSaving', $customerSaving);
    }

    /**
     * Update the specified CustomerSaving in storage.
     *
     * @param int $id
     * @param UpdateCustomerSavingRequest $request
     *
     * @return Response
     */
    public function update($account, $id, UpdateCustomerSavingRequest $request)
    {
        $customerSaving = $this->customerSavingRepository->find($id);

        if (empty($customerSaving)) {
            Flash::error('Customer Saving not found');

            return redirect(route('customerSavings.index', $account));
        }

        $customerSaving = $this->customerSavingRepository->update($request->all(), $id);

        Flash::success('Customer Saving updated successfully.');

        return redirect(route('customerSavings.index', $account));
    }

    /**
     * Remove the specified CustomerSaving from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($account, $id)
    {
        $customerSaving = $this->customerSavingRepository->find($id);

        if (empty($customerSaving)) {
            Flash::error('Customer Saving not found');

            return redirect(route('customerSavings.index', $account));
        }

        $this->customerSavingRepository->delete($id);

        Flash::success('Customer Saving deleted successfully.');

        return redirect(route('customerSavings.index', $account));
    }

    /**
     * @param $account
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showSavingsPayment($account)
    {
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $companyID = session('company_id');
        $customers = Customer::orderBy('surname', 'asc')->where('company_id', $companyID)->get()->pluck('full_name', 'id');
        $bankAccounts = OrgBankAccount::orderBy('account_name', 'asc')->where('company_id', $companyID)->pluck('account_name', 'id')->toArray();
        return view('customer_savings.payment', [
            'customers' => [0 => 'Select Customer'] + $customers->toArray(),
            'companies' => $companies,
            'bankAccounts' => [0 => 'Select Bank Account'] + $bankAccounts,
            'account' => $account
        ]);
    }

    /**
     * @param Request $request
     * @param $account
     * @return \Illuminate\Http\RedirectResponse
     */
    public function makeSavingsPayment(Request $request, $account)
    {
        $input = $request->all();
        try {
            $companyID = $input['company_id'];
            $savingsInfo = CustomerSaving::with(['customer'])->find($input['savings_id']);
            $customer = $savingsInfo->customer;
            $accountHead = $savingsInfo->savings->account_head_id;
            $bankAccount = $input['bank_account'];
            $reference = $input['reference'];
            $narration = $input['narration'];
            $amount = $input['amount'];
            $bankAcc = OrgBankAccount::find($bankAccount);

            $trans = Transactions::processIncome($companyID, $accountHead, $bankAcc->account_head_id, $reference, $narration, $amount, $customer->full_name, auth()->id(), $customer->phone, $customer->email);
            if (!$trans) {
                throw new \Exception("cannot create the transaction record");
            }

            $newTransaction = CustomerTransaction::create([
                'company_id' => $companyID,
                'customer_id' => $customer->id,
                'savings_id' => $input['savings_id'],
                'credit' => $amount,
                'debit' => 0.00,
                'narration' => $narration,
                'reference' => $reference
            ]);

            if (!$newTransaction) {
                throw new \Exception("cannot create new customer transaction.");
            }

            DB::commit();
            return response()->redirectTo("/income/" . encrypt($reference) . "/receipt");

        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            Flash::error($ex->getMessage());
            return redirect()->back()->withInput();
        }
    }


    /**
     * @param Request $request
     * @param $account
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showSavingsPayout(Request $request, $account)
    {
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $companyID = session('company_id');
        $customers = Customer::orderBy('surname', 'asc')->where('company_id', $companyID)->get()->pluck('full_name', 'id');
        $bankAccounts = OrgBankAccount::orderBy('account_name', 'asc')->where('company_id', $companyID)->pluck('account_name', 'id')->toArray();

        return view('customer_savings.liquidate', [
            'companies' => $companies,
            'customers' => $customers,
            'bankAccounts' => $bankAccounts,
            'account' => $account
        ]);
    }

    public function makeSavingsPayout(Request $request, $account)
    {
        DB::beginTransaction();
        $input = $request->all();
        try {
            $companyID = $input['company_id'];
            $customerID = $input['customer_id'];
            $savingsID = $input['savings_id'];
            $bankAccount = $input['bank_account'];
            $reference = $input['reference'];
            $amount = $input['amount'];
            $narration = $input['narration'];
            $customer = Customer::find($customerID);
            $savings = CustomerSaving::with(['savings'])->find($savingsID);
            $accountHead = $savings->savings->account_head_id;

            if (count($customer->bank_accounts) == 0) {
                Log::error("customer bank information not provided.");
                throw new \Exception("Bank details not set for customer");
            }
            if (count($customer->addresses) == 0) {
                throw new \Exception("Customer address not setup properly.");
            }
            $accountInfo = $customer->bank_accounts->first();
            $address = $customer->addresses->first();

            $newPV = PaymentVoucher::create([
                'company_id' => $companyID,
                'payee' => $customer->full_name,
                'address' => $address->street,
                'email' => $customer->email,
                'website' => '',
                'phone' => $customer->phone,
                'pv_id' => strtoupper(uniqid('PV-')),
                'account_name' => $accountInfo->account_name,
                'account_number' => $accountInfo->account_number,
                'bank_id' => $accountInfo->bank_id,
                'status' => "PAID",
                'created_by' => auth()->id(),
            ]);
            if (!$newPV) {
                throw new \Exception("cannot create PV details.");
            }

            $newItem = PaymentVoucherDetails::create([
                'company_id' => $companyID,
                'pv_id' => $newPV->id,
                'account_head_id' => $accountHead,
                'narration' => $narration,
                'rate' => 1,
                'quantity' => 1,
                'amount' => $amount
            ]);

            if (!$newItem) {
                throw new \Exception("Cannot create a new item");
            }

            $customerTransaction = CustomerTransaction::create([
                'company_id' => $companyID,
                'customer_id' => $customerID,
                'savings_id' => $savingsID,
                'debit' => $amount,
                'credit' => 0,
                'narration' => $narration,
                'reference' => $reference
            ]);

            if (!$customerTransaction) {
                throw new \Exception("cannot create customer transaction");
            }

            $user = auth()->id();
            $transaction = Transactions::makePayment($companyID, $newPV->id, $bankAccount, $reference, $narration, $amount, $user, $user, $user);
            if (!$transaction) {
                throw new \Exception("Error making payment, try again.");
            }

            Flash::success("Savings Payout registered successfully.");
            DB::commit();
            return redirect()->to('/customer-savings/liquidate');

        } catch (\Exception $ex) {
            DB::rollBack();
            Flash::error($ex->getMessage());
            dd($ex);
        }
    }
}
