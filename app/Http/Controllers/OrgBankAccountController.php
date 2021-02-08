<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrgBankAccountRequest;
use App\Http\Requests\UpdateOrgBankAccountRequest;
use App\Models\Bank;
use App\Models\Company;
use App\Models\Configuration;
use App\Models\OrgAccountCategory;
use App\Models\OrgAccountHead;
use App\Models\OrgBankAccount;
use App\Repositories\OrgBankAccountRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;
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
        $companies = Company::orderBy('name', 'desc')->pluck('name', 'id');
        $banks = Bank::orderBy('name', 'asc')->pluck('name', 'id');
        return view('org_bank_accounts.create', [
            'companies' => $companies,
            'banks' => $banks
        ]);
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
        $companyID = $input['company_id'];
        $config = Configuration::with('cash_account')->where("company_id", $companyID)->get();
        if (count($config) == 0) {
            Flash::error("Please configure your account heads");
            return redirect(route("configurations.create"));
        }
        $config = $config->first();
        DB::beginTransaction();
        try {
            $code = $config->cash_account->prefix_digit . $input['account_code'];
            if (OrgAccountHead::whereRaw('company_id=? and code=?', [$companyID, $code])->count()) {
                throw new \Exception("Account head exists for this organization, make sure you are not creating a duplicate");
            }
            $accountHead = OrgAccountHead::create([
                'company_id' => $companyID,
                'category_id' => $config->cash_account->id,
                'name' => $input['account_name'],
                'code' => $code,
                'active' => true
            ]);
            if (!$accountHead) {
                Flash::error("Error creating account head, please try again");
                return redirect()->back()->withInput();
            }

            $input['account_head_id'] = $accountHead->id;

            if (OrgBankAccount::whereRaw('company_id=? and account_number=?', [$companyID, $input['account_number']])->count()) {
                throw new \Exception("Bank account exists for this organization, make sure you are not creating a duplicate");
            }

            $orgBankAccount = $this->orgBankAccountRepository->create($input);

            Flash::success('Org Bank Account saved successfully.');
        } catch (\Exception $ex) {
            Flash::error($ex->getMessage());
            DB::rollBack();
            return redirect()->back()->withInput();
        }

        DB::commit();
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
        $companies = Company::orderBy('name', 'desc')->pluck('name', 'id');
        $banks = Bank::orderBy('name', 'asc')->pluck('name', 'id');
        $orgBankAccount = $this->orgBankAccountRepository->find($id);

        if (empty($orgBankAccount)) {
            Flash::error('Org Bank Account not found');

            return redirect(route('orgBankAccounts.index'));
        }

        return view('org_bank_accounts.edit', [
            'companies' => $companies,
            'banks' => $banks
        ])->with('orgBankAccount', $orgBankAccount);
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
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $orgBankAccount = $this->orgBankAccountRepository->find($id);

        DB::beginTransaction();

        try {
            if (empty($orgBankAccount)) {
                Flash::error('Org Bank Account not found');

                return redirect(route('orgBankAccounts.index'));
            }

            // Delete the associated account head first
            OrgAccountHead::find($orgBankAccount->account_head_id)->delete();

            $this->orgBankAccountRepository->delete($id);

            Flash::success('Org Bank Account deleted successfully.');
        } catch (\Exception $ex) {
            Flash::error($ex->getMessage());
            return redirect()->back()->withInput();
        }

        DB::commit();
        return redirect(route('orgBankAccounts.index'));
    }
}
