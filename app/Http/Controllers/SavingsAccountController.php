<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSavingsAccountRequest;
use App\Http\Requests\UpdateSavingsAccountRequest;
use App\Models\Company;
use App\Models\OrgAccountHead;
use App\Models\SavingsAccount;
use App\Models\SavingsCategory;
use App\Repositories\SavingsAccountRepository;
use App\Http\Controllers\AppBaseController;
use App\Utility\Utility;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;
use Response;

class SavingsAccountController extends AppBaseController
{
    /** @var  SavingsAccountRepository */
    private $savingsAccountRepository;

    public function __construct(SavingsAccountRepository $savingsAccountRepo)
    {
        $this->savingsAccountRepository = $savingsAccountRepo;
    }

    /**
     * Display a listing of the SavingsAccount.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $companyID = session('company_id');
        $savingsAccounts = $this->savingsAccountRepository->where("company_id", $companyID);

        return view('savings_accounts.index')
            ->with('savingsAccounts', $savingsAccounts);
    }

    /**
     * Show the form for creating a new SavingsAccount.
     *
     * @return Response
     */
    public function create()
    {
        // TODO: Loan account heads only based off the account category selected
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $companyID = session('company_id');
        $accountHeads = Utility::getAccountHeads($companyID);
        $savingsCategories = SavingsCategory::orderBy('name', 'asc')->where('company_id', $companyID)->pluck('name', 'id');
        return view('savings_accounts.create', [
            'account_heads' => [0 => 'Select Account Head'] + $accountHeads->toArray(),
            'categories' => [0 => 'Select Account Category'] + $savingsCategories->toArray(),
            'companies' => $companies
        ]);
    }

    /**
     * Store a newly created SavingsAccount in storage.
     *
     * @param CreateSavingsAccountRequest $request
     *
     * @return Response
     */
    public function store(CreateSavingsAccountRequest $request)
    {
        $input = $request->all();
        $companyID = session('company_id');
        $savCategory = SavingsCategory::with(['category'])->find($input['savings_category_id']);

        DB::beginTransaction();

        try {
            // create a new account head if code is provided
            if (isset($input['code'])) {

                $code = $savCategory->category->prefix_digit . $input['code'];
                $name = $input['name'];

                if (OrgAccountHead::whereRaw('company_id=? and code=?', [$input['company_id'], $code])->count() > 0) {
                    Flash::error("Code already exists, please provide a new account code or select an existing account");
                    return redirect()->back()->withInput();
                }

                $accountHead = OrgAccountHead::create([
                    'company_id' => $companyID,
                    'name' => $name,
                    'category_id' => $savCategory->category_id,
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

            $savingsAccount = $this->savingsAccountRepository->create($input);
            if (!$savingsAccount) {
                throw new \Exception("Error creating the savings account");
            }

            Flash::success('Savings Account saved successfully.');
            DB::commit();
            return redirect(route('savingsAccounts.index'));
        } catch (\Exception $ex) {
            DB::rollBack();
            Flash::error($ex->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified SavingsAccount.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $savingsAccount = $this->savingsAccountRepository->find($id);

        if (empty($savingsAccount)) {
            Flash::error('Savings Account not found');

            return redirect(route('savingsAccounts.index'));
        }

        return view('savings_accounts.show')->with('savingsAccount', $savingsAccount);
    }

    /**
     * Show the form for editing the specified SavingsAccount.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $savingsAccount = SavingsAccount::with(['account_head'])->find($id);

        if (empty($savingsAccount)) {
            Flash::error('Savings Account not found');

            return redirect(route('savingsAccounts.index'));
        }
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $companyID = session('company_id');
        $accountHeads = Utility::getAccountHeads($companyID);
        $savingsCategories = SavingsCategory::orderBy('name', 'asc')->where('company_id', $companyID)->pluck('name', 'id');

        return view('savings_accounts.edit', [
            'account_heads' => [0 => 'Select Account Head'] + $accountHeads->toArray(),
            'categories' => [0 => 'Select Account Category'] + $savingsCategories->toArray(),
            'companies' => $companies
        ])->with('savingsAccount', $savingsAccount);
    }

    /**
     * Update the specified SavingsAccount in storage.
     *
     * @param int $id
     * @param UpdateSavingsAccountRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSavingsAccountRequest $request)
    {
        $savingsAccount = $this->savingsAccountRepository->find($id);

        if (empty($savingsAccount)) {
            Flash::error('Savings Account not found');

            return redirect(route('savingsAccounts.index'));
        }

        $savingsAccount = $this->savingsAccountRepository->update($request->all(), $id);

        Flash::success('Savings Account updated successfully.');

        return redirect(route('savingsAccounts.index'));
    }

    /**
     * Remove the specified SavingsAccount from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $savingsAccount = $this->savingsAccountRepository->find($id);

        if (empty($savingsAccount)) {
            Flash::error('Savings Account not found');

            return redirect(route('savingsAccounts.index'));
        }

        $this->savingsAccountRepository->delete($id);

        Flash::success('Savings Account deleted successfully.');

        return redirect(route('savingsAccounts.index'));
    }
}
