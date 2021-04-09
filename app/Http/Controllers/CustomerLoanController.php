<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerLoanRequest;
use App\Http\Requests\UpdateCustomerLoanRequest;
use App\Models\Company;
use App\Models\Customer;
use App\Models\CustomerLoan;
use App\Models\CustomerLoanLog;
use App\Models\CustomerTransaction;
use App\Models\LoanApplication;
use App\Models\OrgBankAccount;
use App\Models\Staff;
use App\Repositories\CustomerLoanRepository;
use App\Http\Controllers\AppBaseController;
use App\Utility\Transactions;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Response;

class CustomerLoanController extends AppBaseController
{
    /** @var  CustomerLoanRepository */
    private $customerLoanRepository;

    public function __construct(CustomerLoanRepository $customerLoanRepo)
    {
        $this->customerLoanRepository = $customerLoanRepo;
    }

    /**
     * Display a listing of the CustomerLoan.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $companyID = session('company_id');
        $customerLoans = $this->customerLoanRepository->where('company_id', $companyID);

        return view('customer_loans.index')
            ->with('customerLoans', $customerLoans);
    }

    /**
     * Show the form for creating a new CustomerLoan.
     *
     * @return Response
     */
    public function create()
    {
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $companyID = session('company_id');
        $staff = Staff::where('company_id', $companyID)->pluck('name', 'id');
        $applications = LoanApplication::with(['customer', 'pv'])->whereRaw('company_id=? and status=?', [$companyID, 'PENDING'])->get()->pluck('pv.pv_id', 'id');
        $bankAccounts = OrgBankAccount::orderBy('account_name', 'asc')->where('company_id', $companyID)->pluck('account_name', 'id')->toArray();
        return view('customer_loans.create', [
            'companies' => $companies,
            'staff' => [0 => 'Select Staff'] + $staff->toArray(),
            'bankAccounts' => [0 => 'Select Bank Account'] + $bankAccounts,
            'applications' => [0 => 'Select Application'] + $applications->toArray()
        ]);
    }

    /**
     * Store a newly created CustomerLoan in storage.
     *
     * @param CreateCustomerLoanRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerLoanRequest $request)
    {
        $input = $request->all();

        DB::beginTransaction();
        try {
            $loanInfo = LoanApplication::with(['loan_account'])->find($input['loan_application_id']);
            $bankAccount = $input['debit_account'];
            $amount = $loanInfo->principal;
            $staff = $input['approved_by'];
            $reference = $input['reference'];

            $trans = Transactions::makePayment($input['company_id'], $loanInfo->pv_id, $bankAccount, $reference, $input['narration'], $amount, $staff, $staff, auth()->id());
            if (!$trans) {
                throw new \Exception('cannot create this transaction at the moment.');
            }
            $input['customer_id'] = $loanInfo->customer_id;
            $input['amount'] = $amount;

            unset($input['debit_account']);
            unset($input['reference']);


            $customerLoan = $this->customerLoanRepository->create($input);
            if (!$customerLoan) {
                throw new \Exception("cannot create the customer loan record.");
            }

            $customerTransaction = CustomerTransaction::create([
                'company_id' => $input['company_id'],
                'customer_id' => $loanInfo->customer_id,
                'loan_id' => $customerLoan->id,
                'debit' => $amount,
                'narration' => $input['narration'],
                'reference' => $reference
            ]);
            if (!$customerTransaction) {
                throw new \Exception("Cannot process customer transaction record");
            }

            $loanInfo->status = 'APPROVED';
            if (!$loanInfo->save()) {
                throw new \Exception("cannot update the loan application information");
            }

            DB::commit();

            Flash::success('Customer Loan saved successfully.');
            return redirect(route('customerLoans.index'));
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::info($ex);
            Flash::error($ex->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified CustomerLoan.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customerLoan = $this->customerLoanRepository->find($id);

        if (empty($customerLoan)) {
            Flash::error('Customer Loan not found');

            return redirect(route('customerLoans.index'));
        }

        return view('customer_loans.show', [
            'repayments' => $customerLoan->repayments,
        ])->with('customerLoan', $customerLoan);
    }

    /**
     * Show the form for editing the specified CustomerLoan.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customerLoan = $this->customerLoanRepository->find($id);
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $companyID = session('company_id');
        $staff = Staff::where('company_id', $companyID)->pluck('name', 'id');
        $applications = LoanApplication::with(['customer', 'pv'])->whereRaw('company_id=? and status=?', [$companyID, 'PENDING'])->get()->pluck('pv.pv_id', 'id');
        $bankAccounts = OrgBankAccount::orderBy('account_name', 'asc')->where('company_id', $companyID)->pluck('account_name', 'id')->toArray();

        if (empty($customerLoan)) {
            Flash::error('Customer Loan not found');

            return redirect(route('customerLoans.index'));
        }

        return view('customer_loans.edit', [
            'companies' => $companies,
            'staff' => [0 => 'Select Staff'] + $staff->toArray(),
            'bankAccounts' => $bankAccounts,
            'applications' => [0 => 'Select Application'] + $applications->toArray()
        ])->with('customerLoan', $customerLoan);
    }

    /**
     * Update the specified CustomerLoan in storage.
     *
     * @param int $id
     * @param UpdateCustomerLoanRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerLoanRequest $request)
    {
        $customerLoan = $this->customerLoanRepository->find($id);

        if (empty($customerLoan)) {
            Flash::error('Customer Loan not found');

            return redirect(route('customerLoans.index'));
        }

        $customerLoan = $this->customerLoanRepository->update($request->all(), $id);

        Flash::success('Customer Loan updated successfully.');

        return redirect(route('customerLoans.index'));
    }

    /**
     * Remove the specified CustomerLoan from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $customerLoan = $this->customerLoanRepository->find($id);

        if (empty($customerLoan)) {
            Flash::error('Customer Loan not found');

            return redirect(route('customerLoans.index'));
        }

        $this->customerLoanRepository->delete($id);

        Flash::success('Customer Loan deleted successfully.');

        return redirect(route('customerLoans.index'));
    }
}
