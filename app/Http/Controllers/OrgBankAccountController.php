<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrgBankAccountRequest;
use App\Http\Requests\UpdateOrgBankAccountRequest;
use App\Repositories\OrgBankAccountRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class OrgBankAccountController extends AppBaseController
{
    /** @var  OrgBankAccountRepository */
    private $orgBankAccountRepository;

    public function __construct(OrgBankAccountRepository $orgBankAccountRepo)
    {
        $this->orgBankAccountRepository = $orgBankAccountRepo;
    }

    /**
     * Display a listing of the OrgBankAccount.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $orgBankAccounts = $this->orgBankAccountRepository->all();

        return view('org_bank_accounts.index')
            ->with('orgBankAccounts', $orgBankAccounts);
    }

    /**
     * Show the form for creating a new OrgBankAccount.
     *
     * @return Response
     */
    public function create()
    {
        return view('org_bank_accounts.create');
    }

    /**
     * Store a newly created OrgBankAccount in storage.
     *
     * @param CreateOrgBankAccountRequest $request
     *
     * @return Response
     */
    public function store(CreateOrgBankAccountRequest $request)
    {
        $input = $request->all();

        $orgBankAccount = $this->orgBankAccountRepository->create($input);

        Flash::success('Org Bank Account saved successfully.');

        return redirect(route('orgBankAccounts.index'));
    }

    /**
     * Display the specified OrgBankAccount.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $orgBankAccount = $this->orgBankAccountRepository->find($id);

        if (empty($orgBankAccount)) {
            Flash::error('Org Bank Account not found');

            return redirect(route('orgBankAccounts.index'));
        }

        return view('org_bank_accounts.show')->with('orgBankAccount', $orgBankAccount);
    }

    /**
     * Show the form for editing the specified OrgBankAccount.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $orgBankAccount = $this->orgBankAccountRepository->find($id);

        if (empty($orgBankAccount)) {
            Flash::error('Org Bank Account not found');

            return redirect(route('orgBankAccounts.index'));
        }

        return view('org_bank_accounts.edit')->with('orgBankAccount', $orgBankAccount);
    }

    /**
     * Update the specified OrgBankAccount in storage.
     *
     * @param int $id
     * @param UpdateOrgBankAccountRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOrgBankAccountRequest $request)
    {
        $orgBankAccount = $this->orgBankAccountRepository->find($id);

        if (empty($orgBankAccount)) {
            Flash::error('Org Bank Account not found');

            return redirect(route('orgBankAccounts.index'));
        }

        $orgBankAccount = $this->orgBankAccountRepository->update($request->all(), $id);

        Flash::success('Org Bank Account updated successfully.');

        return redirect(route('orgBankAccounts.index'));
    }

    /**
     * Remove the specified OrgBankAccount from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $orgBankAccount = $this->orgBankAccountRepository->find($id);

        if (empty($orgBankAccount)) {
            Flash::error('Org Bank Account not found');

            return redirect(route('orgBankAccounts.index'));
        }

        $this->orgBankAccountRepository->delete($id);

        Flash::success('Org Bank Account deleted successfully.');

        return redirect(route('orgBankAccounts.index'));
    }
}
