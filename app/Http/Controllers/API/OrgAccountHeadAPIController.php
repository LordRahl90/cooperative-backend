<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateOrgAccountHeadAPIRequest;
use App\Http\Requests\API\UpdateOrgAccountHeadAPIRequest;
use App\Models\OrgAccountHead;
use App\Repositories\OrgAccountHeadRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class OrgAccountHeadController
 * @package App\Http\Controllers\API
 */

class OrgAccountHeadAPIController extends AppBaseController
{
    /** @var  OrgAccountHeadRepository */
    private $orgAccountHeadRepository;

    public function __construct(OrgAccountHeadRepository $orgAccountHeadRepo)
    {
        $this->orgAccountHeadRepository = $orgAccountHeadRepo;
    }

    /**
     * Display a listing of the OrgAccountHead.
     * GET|HEAD /orgAccountHeads
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $orgAccountHeads = $this->orgAccountHeadRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($orgAccountHeads->toArray(), 'Org Account Heads retrieved successfully');
    }

    /**
     * Store a newly created OrgAccountHead in storage.
     * POST /orgAccountHeads
     *
     * @param CreateOrgAccountHeadAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateOrgAccountHeadAPIRequest $request)
    {
        $input = $request->all();

        $orgAccountHead = $this->orgAccountHeadRepository->create($input);

        return $this->sendResponse($orgAccountHead->toArray(), 'Org Account Head saved successfully');
    }

    /**
     * Display the specified OrgAccountHead.
     * GET|HEAD /orgAccountHeads/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var OrgAccountHead $orgAccountHead */
        $orgAccountHead = $this->orgAccountHeadRepository->find($id);

        if (empty($orgAccountHead)) {
            return $this->sendError('Org Account Head not found');
        }

        return $this->sendResponse($orgAccountHead->toArray(), 'Org Account Head retrieved successfully');
    }

    /**
     * Update the specified OrgAccountHead in storage.
     * PUT/PATCH /orgAccountHeads/{id}
     *
     * @param int $id
     * @param UpdateOrgAccountHeadAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOrgAccountHeadAPIRequest $request)
    {
        $input = $request->all();

        /** @var OrgAccountHead $orgAccountHead */
        $orgAccountHead = $this->orgAccountHeadRepository->find($id);

        if (empty($orgAccountHead)) {
            return $this->sendError('Org Account Head not found');
        }

        $orgAccountHead = $this->orgAccountHeadRepository->update($input, $id);

        return $this->sendResponse($orgAccountHead->toArray(), 'OrgAccountHead updated successfully');
    }

    /**
     * Remove the specified OrgAccountHead from storage.
     * DELETE /orgAccountHeads/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var OrgAccountHead $orgAccountHead */
        $orgAccountHead = $this->orgAccountHeadRepository->find($id);

        if (empty($orgAccountHead)) {
            return $this->sendError('Org Account Head not found');
        }

        $orgAccountHead->delete();

        return $this->sendSuccess('Org Account Head deleted successfully');
    }
}
