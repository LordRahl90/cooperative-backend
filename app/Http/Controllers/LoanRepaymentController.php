<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLoanRepaymentRequest;
use App\Http\Requests\UpdateLoanRepaymentRequest;
use App\Models\Company;
use App\Models\Customer;
use App\Models\CustomerLoan;
use App\Models\CustomerLoanLog;
use App\Models\CustomerTransaction;
use App\Models\OrgBankAccount;
use App\Repositories\LoanRepaymentRepository;
use App\Http\Controllers\AppBaseController;
use App\Utility\Transactions;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;
use Response;

class LoanRepaymentController extends AppBaseController
{
    /** @var  LoanRepaymentRepository */
    private $loanRepaymentRepository;

    public function __construct(LoanRepaymentRepository $loanRepaymentRepo)
    {
        $this->loanRepaymentRepository = $loanRepaymentRepo;
    }

    /**
     * Display a listing of the LoanRepayment.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $loanRepayments = $this->loanRepaymentRepository->where('company_id', session('company_id'));

        return view('loan_repayments.index')
            ->with('loanRepayments', $loanRepayments);
    }

    /**
     * Show the form for creating a new LoanRepayment.
     *
     * @return Response
     */
    public function create()
    {
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $companyID = session('company_id');
        $customers = Customer::orderBy('surname', 'asc')->where('company_id', $companyID)->get()->pluck('full_name', 'id');
        $bankAccounts = OrgBankAccount::orderBy('account_name', 'asc')->where('company_id', $companyID)->pluck('account_name', 'id')->toArray();
        return view('loan_repayments.create', [
            'customers' => [0 => 'Select Customer'] + $customers->toArray(),
            'companies' => $companies,
            'bankAccounts' => [0 => 'Select Bank Account'] + $bankAccounts
        ]);
    }

    /**
     * Store a newly created LoanRepayment in storage.
     *
     * @param CreateLoanRepaymentRequest $request
     *
     * @return Response
     */
    public function store(CreateLoanRepaymentRequest $request)
    {
        $input = $request->all();
//        dd($input);

        DB::beginTransaction();
        try {
            $companyID = $input['company_id'];
            $loanInfo = CustomerLoan::with(['loan_application.loan_account'])->find($input['loan_id']);
            $customer = $loanInfo->customer;
            $accountHead = $loanInfo->loan_application->loan_account->account_head_id;
            $bankAccount = $input['bank_account'];
            $reference = $input['reference'];
            $narration = $input['narration'];
            $principal = $input['principal'];
            $interest = $input['interest'];
            $amount = $principal + $interest;
            $bankAcc = OrgBankAccount::find($bankAccount);


            $trans = Transactions::processIncome($companyID, $accountHead, $bankAcc->account_head_id, $reference, $narration, $amount, $customer->full_name, auth()->id(), $customer->phone, $customer->email);
            if (!$trans) {
                throw new \Exception("cannot create the transaction record");
            }
            $loanRepayment = $this->loanRepaymentRepository->create([
                'company_id' => $companyID,
                'loan_application_id' => $loanInfo->loan_application_id,
                'loan_id' => $input['loan_id'],
                'customer_id' => $customer->id,
                'principal' => $principal,
                'interest' => $interest
            ]);

            if (!$loanRepayment) {
                throw new \Exception("cannot create the loan repayment record");
            }

            $newTransaction = CustomerTransaction::create([
                'company_id' => $companyID,
                'customer_id' => $customer->id,
                'loan_id' => $input['loan_id'],
                'debit' => 0.00,
                'credit' => $amount,
                'narration' => $narration,
                'reference' => $reference
            ]);

            if (!$newTransaction) {
                throw new \Exception("cannot create new customer transaction.");
            }

            $loanLog = CustomerLoanLog::create([
                'company_id' => $companyID,
                'customer_id' => $customer->id,
                'loan_id' => $input['loan_id'],
                'reference' => $reference,
                'narration' => $narration,
                'credit' => $amount,
                'debit' => 0.0
            ]);
            if (!$loanLog) {
                throw new \Exception('Cannot log this loan detail at the moment.');
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
     * Display the specified LoanRepayment.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $loanRepayment = $this->loanRepaymentRepository->find($id);

        if (empty($loanRepayment)) {
            Flash::error('Loan Repayment not found');

            return redirect(route('loanRepayments.index'));
        }

        return view('loan_repayments.show')->with('loanRepayment', $loanRepayment);
    }

    /**
     * Show the form for editing the specified LoanRepayment.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $loanRepayment = $this->loanRepaymentRepository->find($id);

        if (empty($loanRepayment)) {
            Flash::error('Loan Repayment not found');

            return redirect(route('loanRepayments.index'));
        }

        return view('loan_repayments.edit')->with('loanRepayment', $loanRepayment);
    }

    /**
     * Update the specified LoanRepayment in storage.
     *
     * @param int $id
     * @param UpdateLoanRepaymentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLoanRepaymentRequest $request)
    {
        $loanRepayment = $this->loanRepaymentRepository->find($id);

        if (empty($loanRepayment)) {
            Flash::error('Loan Repayment not found');

            return redirect(route('loanRepayments.index'));
        }

        $loanRepayment = $this->loanRepaymentRepository->update($request->all(), $id);

        Flash::success('Loan Repayment updated successfully.');

        return redirect(route('loanRepayments.index'));
    }

    /**
     * Remove the specified LoanRepayment from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $loanRepayment = $this->loanRepaymentRepository->find($id);

        if (empty($loanRepayment)) {
            Flash::error('Loan Repayment not found');

            return redirect(route('loanRepayments.index'));
        }

        $this->loanRepaymentRepository->delete($id);

        Flash::success('Loan Repayment deleted successfully.');

        return redirect(route('loanRepayments.index'));
    }
}
