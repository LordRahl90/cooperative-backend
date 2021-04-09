<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAccountHeadAPIRequest;
use App\Http\Requests\API\UpdateAccountHeadAPIRequest;
use App\Models\AccountHead;
use App\Repositories\AccountHeadRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AccountHeadController
 * @package App\Http\Controllers\API
 */

class AccountHeadAPIController extends AppBaseController
{
    /** @var  AccountHeadRepository */
    private $accountHeadRepository;

    public function __construct(AccountHeadRepository $accountHeadRepo)
    {
        $this->accountHeadRepository = $accountHeadRepo;
    }

    /**
     * Display a listing of the AccountHead.
     * GET|HEAD /accountHeads
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $accountHeads = $this->accountHeadRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($accountHeads->toArray(), 'Account Heads retrieved successfully');
    }

    /**
     * Store a newly created AccountHead in storage.
     * POST /accountHeads
     *
     * @param CreateAccountHeadAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAccountHeadAPIRequest $request)
    {
        $input = $request->all();

        $accountHead = $this->accountHeadRepository->create($input);

        return $this->sendResponse($accountHead->toArray(), 'Account Head saved successfully');
    }

    /**
     * Display the specified AccountHead.
     * GET|HEAD /accountHeads/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AccountHead $accountHead */
        $accountHead = $this->accountHeadRepository->find($id);

        if (empty($accountHead)) {
            return $this->sendError('Account Head not found');
        }

        return $this->sendResponse($accountHead->toArray(), 'Account Head retrieved successfully');
    }

    /**
     * Update the specified AccountHead in storage.
     * PUT/PATCH /accountHeads/{id}
     *
     * @param int $id
     * @param UpdateAccountHeadAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAccountHeadAPIRequest $request)
    {
        $input = $request->all();

        /** @var AccountHead $accountHead */
        $accountHead = $this->accountHeadRepository->find($id);

        if (empty($accountHead)) {
            return $this->sendError('Account Head not found');
        }

        $accountHead = $this->accountHeadRepository->update($input, $id);

        return $this->sendResponse($accountHead->toArray(), 'AccountHead updated successfully');
    }

    /**
     * Remove the specified AccountHead from storage.
     * DELETE /accountHeads/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var AccountHead $accountHead */
        $accountHead = $this->accountHeadRepository->find($id);

        if (empty($accountHead)) {
            return $this->sendError('Account Head not found');
        }

        $accountHead->delete();

        return $this->sendSuccess('Account Head deleted successfully');
    }
}
