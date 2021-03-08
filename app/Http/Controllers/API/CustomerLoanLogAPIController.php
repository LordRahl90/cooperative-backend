<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCustomerLoanLogAPIRequest;
use App\Http\Requests\API\UpdateCustomerLoanLogAPIRequest;
use App\Models\CustomerLoanLog;
use App\Repositories\CustomerLoanLogRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CustomerLoanLogController
 * @package App\Http\Controllers\API
 */

class CustomerLoanLogAPIController extends AppBaseController
{
    /** @var  CustomerLoanLogRepository */
    private $customerLoanLogRepository;

    public function __construct(CustomerLoanLogRepository $customerLoanLogRepo)
    {
        $this->customerLoanLogRepository = $customerLoanLogRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/customerLoanLogs",
     *      summary="Get a listing of the CustomerLoanLogs.",
     *      tags={"CustomerLoanLog"},
     *      description="Get all CustomerLoanLogs",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/CustomerLoanLog")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $customerLoanLogs = $this->customerLoanLogRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($customerLoanLogs->toArray(), 'Customer Loan Logs retrieved successfully');
    }

    /**
     * @param CreateCustomerLoanLogAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/customerLoanLogs",
     *      summary="Store a newly created CustomerLoanLog in storage",
     *      tags={"CustomerLoanLog"},
     *      description="Store CustomerLoanLog",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CustomerLoanLog that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CustomerLoanLog")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/CustomerLoanLog"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCustomerLoanLogAPIRequest $request)
    {
        $input = $request->all();

        $customerLoanLog = $this->customerLoanLogRepository->create($input);

        return $this->sendResponse($customerLoanLog->toArray(), 'Customer Loan Log saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/customerLoanLogs/{id}",
     *      summary="Display the specified CustomerLoanLog",
     *      tags={"CustomerLoanLog"},
     *      description="Get CustomerLoanLog",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CustomerLoanLog",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/CustomerLoanLog"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var CustomerLoanLog $customerLoanLog */
        $customerLoanLog = $this->customerLoanLogRepository->find($id);

        if (empty($customerLoanLog)) {
            return $this->sendError('Customer Loan Log not found');
        }

        return $this->sendResponse($customerLoanLog->toArray(), 'Customer Loan Log retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCustomerLoanLogAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/customerLoanLogs/{id}",
     *      summary="Update the specified CustomerLoanLog in storage",
     *      tags={"CustomerLoanLog"},
     *      description="Update CustomerLoanLog",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CustomerLoanLog",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CustomerLoanLog that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CustomerLoanLog")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/CustomerLoanLog"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCustomerLoanLogAPIRequest $request)
    {
        $input = $request->all();

        /** @var CustomerLoanLog $customerLoanLog */
        $customerLoanLog = $this->customerLoanLogRepository->find($id);

        if (empty($customerLoanLog)) {
            return $this->sendError('Customer Loan Log not found');
        }

        $customerLoanLog = $this->customerLoanLogRepository->update($input, $id);

        return $this->sendResponse($customerLoanLog->toArray(), 'CustomerLoanLog updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/customerLoanLogs/{id}",
     *      summary="Remove the specified CustomerLoanLog from storage",
     *      tags={"CustomerLoanLog"},
     *      description="Delete CustomerLoanLog",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CustomerLoanLog",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var CustomerLoanLog $customerLoanLog */
        $customerLoanLog = $this->customerLoanLogRepository->find($id);

        if (empty($customerLoanLog)) {
            return $this->sendError('Customer Loan Log not found');
        }

        $customerLoanLog->delete();

        return $this->sendSuccess('Customer Loan Log deleted successfully');
    }
}
