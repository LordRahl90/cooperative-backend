<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLoanAccountRequest;
use App\Http\Requests\UpdateLoanAccountRequest;
use App\Models\Company;
use App\Models\LoanAccount;
use App\Models\LoanCategory;
use App\Models\OrgAccountHead;
use App\Models\OrgBankAccount;
use App\Models\SavingsCategory;
use App\Repositories\LoanAccountRepository;
use App\Http\Controllers\AppBaseController;
use App\Utility\Utility;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;
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
    public function index(Request $request, $account)
    {
        $companyID = session('company_id');
        $loanAccounts = $this->loanAccountRepository->where("company_id", $companyID);

        return view('loan_accounts.index', ['account' => $account])
            ->with('loanAccounts', $loanAccounts);
    }

    /**
     * Show the form for creating a new LoanAccount.
     *
     * @return Response
     */
    public function create($account)
    {
        $companyID = session('company_id');
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $accountHeads = Utility::getAccountHeads($companyID);
        $savingsCategories = LoanCategory::orderBy('name', 'asc')->where('company_id', $companyID)->pluck('name', 'id');
        return view('loan_accounts.create', [
            'companies' => $companies,
            'account_heads' => [0 => 'Select Account Heads'] + $accountHeads->toArray(),
            'categories' => [0 => 'Select Account Category'] + $savingsCategories->toArray(),
            'account' => $account
        ]);
    }

    /**
     * Store a newly created LoanAccount in storage.
     *
     * @param CreateLoanAccountRequest $request
     *
     * @return Response
     */
    public function store(CreateLoanAccountRequest $request, $account)
    {
        $input = $request->all();
        $companyID = session('company_id');
        $loanCategory = LoanCategory::with(['category'])->find($input['loan_category_id']);

        DB::beginTransaction();

        try {
            // create a new account head if code is provided
            if (isset($input['code'])) {

                $code = $loanCategory->category->prefix_digit . $input['code'];
                $name = $input['name'];

                if (OrgAccountHead::whereRaw('company_id=? and code=?', [$input['company_id'], $code])->count() > 0) {
                    Flash::error("Code already exists, please provide a new account code or select an existing account");
                    return redirect()->back()->withInput();
                }

                $accountHead = OrgAccountHead::create([
                    'company_id' => $companyID,
                    'name' => $name,
                    'category_id' => $loanCategory->category_id,
                    'code' => $code,
                    'active' => true
                ]);
                if (!$accountHead) {
                    throw new \Exception("cannot create account head.");
                }
                $input['account_head_id'] = $accountHead->id;
            }
            if (isset($input['account_head_id'])) {
                // get the account code and populate input with it.
                $accountHead = OrgAccountHead::find($input['account_head_id']);

                $input['code'] = $accountHead->code;
            }

            $loanAccount = $this->loanAccountRepository->create($input);
            if (!$loanAccount) {
                throw new \Exception("Error creating the savings account");
            }

            Flash::success('Loan Account saved successfully.');
            DB::commit();
            return redirect(route('loanAccounts.index', $account));
        } catch (\Exception $ex) {
            DB::rollBack();
            Flash::error($ex->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified LoanAccount.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($account, $id)
    {
        $loanAccount = $this->loanAccountRepository->find($id);

        if (empty($loanAccount)) {
            Flash::error('Loan Account not found');

            return redirect(route('loanAccounts.index', $account));
        }

        return view('loan_accounts.show', ['account' => $account])->with('loanAccount', $loanAccount);
    }

    /**
     * Show the form for editing the specified LoanAccount.
     *
     * @param $account
     * @param int $id
     *
     * @return Response
     */
    public function edit($account, $id)
    {
        $loanAccount = LoanAccount::with(['account_head'])->find($id);

        if (empty($loanAccount)) {
            Flash::error('Loan Account not found');

            return redirect(route('loanAccounts.index', $account));
        }

        $companyID = session('company_id');
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $accountHeads = Utility::getAccountHeads($companyID);
        $savingsCategories = LoanCategory::orderBy('name', 'asc')->where('company_id', $companyID)->pluck('name', 'id');

        return view('loan_accounts.edit', [
            'companies' => $companies,
            'account_heads' => [0 => 'Select Account Heads'] + $accountHeads->toArray(),
            'categories' => [0 => 'Select Account Category'] + $savingsCategories->toArray(),
            'account' => $account
        ])->with('loanAccount', $loanAccount);
    }

    /**
     * Update the specified LoanAccount in storage.
     *
     * @param $account
     * @param int $id
     * @param UpdateLoanAccountRequest $request
     *
     * @return Response
     */
    public function update($account, $id, UpdateLoanAccountRequest $request)
    {
        $loanAccount = $this->loanAccountRepository->find($id);

        if (empty($loanAccount)) {
            Flash::error('Loan Account not found');

            return redirect(route('loanAccounts.index', $account));
        }

        $loanAccount = $this->loanAccountRepository->update($request->all(), $id);

        Flash::success('Loan Account updated successfully.');

        return redirect(route('loanAccounts.index', $account));
    }

    /**
     * Remove the specified LoanAccount from storage.
     *
     * @param $account
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     */
    public function destroy($account, $id)
    {
        $loanAccount = $this->loanAccountRepository->find($id);

        if (empty($loanAccount)) {
            Flash::error('Loan Account not found');

            return redirect(route('loanAccounts.index', $account));
        }

        $this->loanAccountRepository->delete($id);

        Flash::success('Loan Account deleted successfully.');

        return redirect(route('loanAccounts.index', $account));
    }
}
