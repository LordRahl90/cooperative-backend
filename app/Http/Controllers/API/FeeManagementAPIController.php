<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFeeManagementAPIRequest;
use App\Http\Requests\API\UpdateFeeManagementAPIRequest;
use App\Models\FeeManagement;
use App\Repositories\FeeManagementRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class FeeManagementController
 * @package App\Http\Controllers\API
 */

class FeeManagementAPIController extends AppBaseController
{
    /** @var  FeeManagementRepository */
    private $feeManagementRepository;

    public function __construct(FeeManagementRepository $feeManagementRepo)
    {
        $this->feeManagementRepository = $feeManagementRepo;
    }

    /**
     * Display a listing of the FeeManagement.
     * GET|HEAD /feeManagements
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $feeManagements = $this->feeManagementRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($feeManagements->toArray(), 'Fee Managements retrieved successfully');
    }

    /**
     * Store a newly created FeeManagement in storage.
     * POST /feeManagements
     *
     * @param CreateFeeManagementAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateFeeManagementAPIRequest $request)
    {
        $input = $request->all();

        $feeManagement = $this->feeManagementRepository->create($input);

        return $this->sendResponse($feeManagement->toArray(), 'Fee Management saved successfully');
    }

    /**
     * Display the specified FeeManagement.
     * GET|HEAD /feeManagements/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var FeeManagement $feeManagement */
        $feeManagement = $this->feeManagementRepository->find($id);

        if (empty($feeManagement)) {
            return $this->sendError('Fee Management not found');
        }

        return $this->sendResponse($feeManagement->toArray(), 'Fee Management retrieved successfully');
    }

    /**
     * Update the specified FeeManagement in storage.
     * PUT/PATCH /feeManagements/{id}
     *
     * @param int $id
     * @param UpdateFeeManagementAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFeeManagementAPIRequest $request)
    {
        $input = $request->all();

        /** @var FeeManagement $feeManagement */
        $feeManagement = $this->feeManagementRepository->find($id);

        if (empty($feeManagement)) {
            return $this->sendError('Fee Management not found');
        }

        $feeManagement = $this->feeManagementRepository->update($input, $id);

        return $this->sendResponse($feeManagement->toArray(), 'FeeManagement updated successfully');
    }

    /**
     * Remove the specified FeeManagement from storage.
     * DELETE /feeManagements/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var FeeManagement $feeManagement */
        $feeManagement = $this->feeManagementRepository->find($id);

        if (empty($feeManagement)) {
            return $this->sendError('Fee Management not found');
        }

        $feeManagement->delete();

        return $this->sendSuccess('Fee Management deleted successfully');
    }
}
