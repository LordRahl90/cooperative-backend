<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLoanAccountRequest;
use App\Http\Requests\UpdateLoanAccountRequest;
use App\Models\Company;
use App\Models\LoanCategory;
use App\Repositories\LoanAccountRepository;
use App\Http\Controllers\AppBaseController;
use App\Utility\Utility;
use Illuminate\Http\Request;
use Flash;
use Response;

class LoanAccountController extends AppBaseController
{
    /** @var  LoanAccountRepository */
    private $loanAccountRepository;

    public function __construct(LoanAccountRepository $loanAccountRepo)
    {
        $this->loanAccountRepository = $loanAccountRepo;
    }

    /**
     * Display a listing of the LoanAccount.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $loanAccounts = $this->loanAccountRepository->all();

        return view('loan_accounts.index')
            ->with('loanAccounts', $loanAccounts);
    }

    /**
     * Show the form for creating a new LoanAccount.
     *
     * @return Response
     */
    public function create()
    {
        $companyID = session('company_id');
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $accountHeads = Utility::getAccountHeads($companyID);
        $savingsCategories = LoanCategory::orderBy('name', 'asc')->where('company_id', $companyID)->pluck('name', 'id');
        return view('loan_accounts.create', [
            'companies' => $companies,
            'account_heads' => $accountHeads,
            'categories' => $savingsCategories
        ]);
    }

    /**
     * Store a newly created LoanAccount in storage.
     *
     * @param CreateLoanAccountRequest $request
     *
     * @return Response
     */
    public function store(CreateLoanAccountRequest $request)
    {
        $input = $request->all();

        $loanAccount = $this->loanAccountRepository->create($input);

        Flash::success('Loan Account saved successfully.');

        return redirect(route('loanAccounts.index'));
    }

    /**
     * Display the specified LoanAccount.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $loanAccount = $this->loanAccountRepository->find($id);

        if (empty($loanAccount)) {
            Flash::error('Loan Account not found');

            return redirect(route('loanAccounts.index'));
        }

        return view('loan_accounts.show')->with('loanAccount', $loanAccount);
    }

    /**
     * Show the form for editing the specified LoanAccount.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $loanAccount = $this->loanAccountRepository->find($id);

        if (empty($loanAccount)) {
            Flash::error('Loan Account not found');

            return redirect(route('loanAccounts.index'));
        }

        return view('loan_accounts.edit')->with('loanAccount', $loanAccount);
    }

    /**
     * Update the specified LoanAccount in storage.
     *
     * @param int $id
     * @param UpdateLoanAccountRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLoanAccountRequest $request)
    {
        $loanAccount = $this->loanAccountRepository->find($id);

        if (empty($loanAccount)) {
            Flash::error('Loan Account not found');

            return redirect(route('loanAccounts.index'));
        }

        $loanAccount = $this->loanAccountRepository->update($request->all(), $id);

        Flash::success('Loan Account updated successfully.');

        return redirect(route('loanAccounts.index'));
    }

    /**
     * Remove the specified LoanAccount from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $loanAccount = $this->loanAccountRepository->find($id);

        if (empty($loanAccount)) {
            Flash::error('Loan Account not found');

            return redirect(route('loanAccounts.index'));
        }

        $this->loanAccountRepository->delete($id);

        Flash::success('Loan Account deleted successfully.');

        return redirect(route('loanAccounts.index'));
    }
}
