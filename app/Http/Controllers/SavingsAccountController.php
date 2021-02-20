<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSavingsAccountRequest;
use App\Http\Requests\UpdateSavingsAccountRequest;
use App\Models\Company;
use App\Models\SavingsCategory;
use App\Repositories\SavingsAccountRepository;
use App\Http\Controllers\AppBaseController;
use App\Utility\Utility;
use Illuminate\Http\Request;
use Flash;
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
        $savingsAccounts = $this->savingsAccountRepository->all();

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
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $companyID = session('company_id');
        $accountHeads = Utility::getAccountHeads($companyID);
        $savingsCategories = SavingsCategory::orderBy('name', 'asc')->where('company_id', $companyID)->pluck('name', 'id');
        return view('savings_accounts.create', [
            'account_heads' => $accountHeads,
            'categories' => $savingsCategories,
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

        $savingsAccount = $this->savingsAccountRepository->create($input);

        Flash::success('Savings Account saved successfully.');

        return redirect(route('savingsAccounts.index'));
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
        $savingsAccount = $this->savingsAccountRepository->find($id);

        if (empty($savingsAccount)) {
            Flash::error('Savings Account not found');

            return redirect(route('savingsAccounts.index'));
        }

        return view('savings_accounts.edit')->with('savingsAccount', $savingsAccount);
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
