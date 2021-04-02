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
use App\Models\SavingsAccount;
use App\Repositories\CustomerSavingRepository;
use App\Http\Controllers\AppBaseController;
use App\Utility\Transactions;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;
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
    public function index(Request $request)
    {
        $companyID = session('company_id');
        $customerSavings = $this->customerSavingRepository->where('company_id', $companyID);

        return view('customer_savings.index')
            ->with('customerSavings', $customerSavings);
    }

    /**
     * Show the form for creating a new CustomerSaving.
     *
     * @return Response
     */
    public function create()
    {
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $companyID = session('company_id');
        $customers = Customer::orderBy('surname', 'asc')->where('company_id', $companyID)->get()->pluck('full_name', 'id');
        $savings = SavingsAccount::orderBy('name', 'asc')->where('company_id', $companyID)->pluck('name', 'id')->toArray();
        return view('customer_savings.create', [
            'companies' => $companies,
            'customers' => $customers,
            'savingsAccount' => $savings
        ]);
    }

    /**
     * Store a newly created CustomerSaving in storage.
     *
     * @param CreateCustomerSavingRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerSavingRequest $request)
    {
        $input = $request->all();

        $customerSaving = $this->customerSavingRepository->create($input);

        Flash::success('Customer Saving saved successfully.');

        return redirect(route('customerSavings.index'));
    }

    /**
     * Display the specified CustomerSaving.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customerSaving = $this->customerSavingRepository->find($id);

        if (empty($customerSaving)) {
            Flash::error('Customer Saving not found');

            return redirect(route('customerSavings.index'));
        }

        return view('customer_savings.show')->with('customerSaving', $customerSaving);
    }

    /**
     * Show the form for editing the specified CustomerSaving.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customerSaving = $this->customerSavingRepository->find($id);
        if (empty($customerSaving)) {
            Flash::error('Customer Saving not found');

            return redirect(route('customerSavings.index'));
        }
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $companyID = session('company_id');
        $customers = Customer::orderBy('surname', 'asc')->where('company_id', $companyID)->get()->pluck('full_name', 'id');
        $savings = SavingsAccount::orderBy('name', 'asc')->where('company_id', $companyID)->pluck('name', 'id')->toArray();

        return view('customer_savings.edit', [
            'companies' => $companies,
            'customers' => $customers,
            'savingsAccount' => $savings
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
    public function update($id, UpdateCustomerSavingRequest $request)
    {
        $customerSaving = $this->customerSavingRepository->find($id);

        if (empty($customerSaving)) {
            Flash::error('Customer Saving not found');

            return redirect(route('customerSavings.index'));
        }

        $customerSaving = $this->customerSavingRepository->update($request->all(), $id);

        Flash::success('Customer Saving updated successfully.');

        return redirect(route('customerSavings.index'));
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
    public function destroy($id)
    {
        $customerSaving = $this->customerSavingRepository->find($id);

        if (empty($customerSaving)) {
            Flash::error('Customer Saving not found');

            return redirect(route('customerSavings.index'));
        }

        $this->customerSavingRepository->delete($id);

        Flash::success('Customer Saving deleted successfully.');

        return redirect(route('customerSavings.index'));
    }

    public function showSavingsPayment()
    {
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $companyID = session('company_id');
        $customers = Customer::orderBy('surname', 'asc')->where('company_id', $companyID)->get()->pluck('full_name', 'id');
        $bankAccounts = OrgBankAccount::orderBy('account_name', 'asc')->where('company_id', $companyID)->pluck('account_name', 'id')->toArray();
        return view('customer_savings.payment', [
            'customers' => [0 => 'Select Customer'] + $customers->toArray(),
            'companies' => $companies,
            'bankAccounts' => [0 => 'Select Bank Account'] + $bankAccounts
        ]);
    }

    public function makeSavingsPayment(Request $request)
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
}
