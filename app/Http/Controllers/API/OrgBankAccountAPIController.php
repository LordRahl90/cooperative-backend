<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateOrgBankAccountAPIRequest;
use App\Http\Requests\API\UpdateOrgBankAccountAPIRequest;
use App\Models\OrgBankAccount;
use App\Repositories\OrgBankAccountRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class OrgBankAccountController
 * @package App\Http\Controllers\API
 */

class OrgBankAccountAPIController extends AppBaseController
{
    /** @var  OrgBankAccountRepository */
    private $orgBankAccountRepository;

    public function __construct(OrgBankAccountRepository $orgBankAccountRepo)
    {
        $this->orgBankAccountRepository = $orgBankAccountRepo;
    }

    /**
     * Display a listing of the OrgBankAccount.
     * GET|HEAD /orgBankAccounts
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $orgBankAccounts = $this->orgBankAccountRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($orgBankAccounts->toArray(), 'Org Bank Accounts retrieved successfully');
    }

    /**
     * Store a newly created OrgBankAccount in storage.
     * POST /orgBankAccounts
     *
     * @param CreateOrgBankAccountAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateOrgBankAccountAPIRequest $request)
    {
        $input = $request->all();

        $orgBankAccount = $this->orgBankAccountRepository->create($input);

        return $this->sendResponse($orgBankAccount->toArray(), 'Org Bank Account saved successfully');
    }

    /**
     * Display the specified OrgBankAccount.
     * GET|HEAD /orgBankAccounts/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var OrgBankAccount $orgBankAccount */
        $orgBankAccount = $this->orgBankAccountRepository->find($id);

        if (empty($orgBankAccount)) {
            return $this->sendError('Org Bank Account not found');
        }

        return $this->sendResponse($orgBankAccount->toArray(), 'Org Bank Account retrieved successfully');
    }

    /**
     * Update the specified OrgBankAccount in storage.
     * PUT/PATCH /orgBankAccounts/{id}
     *
     * @param int $id
     * @param UpdateOrgBankAccountAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOrgBankAccountAPIRequest $request)
    {
        $input = $request->all();

        /** @var OrgBankAccount $orgBankAccount */
        $orgBankAccount = $this->orgBankAccountRepository->find($id);

        if (empty($orgBankAccount)) {
            return $this->sendError('Org Bank Account not found');
        }

        $orgBankAccount = $this->orgBankAccountRepository->update($input, $id);

        return $this->sendResponse($orgBankAccount->toArray(), 'OrgBankAccount updated successfully');
    }

    /**
     * Remove the specified OrgBankAccount from storage.
     * DELETE /orgBankAccounts/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var OrgBankAccount $orgBankAccount */
        $orgBankAccount = $this->orgBankAccountRepository->find($id);

        if (empty($orgBankAccount)) {
            return $this->sendError('Org Bank Account not found');
        }

        $orgBankAccount->delete();

        return $this->sendSuccess('Org Bank Account deleted successfully');
    }
}
