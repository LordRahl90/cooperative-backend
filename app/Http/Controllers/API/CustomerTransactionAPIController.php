<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCustomerTransactionAPIRequest;
use App\Http\Requests\API\UpdateCustomerTransactionAPIRequest;
use App\Models\CustomerTransaction;
use App\Repositories\CustomerTransactionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CustomerTransactionController
 * @package App\Http\Controllers\API
 */

class CustomerTransactionAPIController extends AppBaseController
{
    /** @var  CustomerTransactionRepository */
    private $customerTransactionRepository;

    public function __construct(CustomerTransactionRepository $customerTransactionRepo)
    {
        $this->customerTransactionRepository = $customerTransactionRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/customerTransactions",
     *      summary="Get a listing of the CustomerTransactions.",
     *      tags={"CustomerTransaction"},
     *      description="Get all CustomerTransactions",
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
     *                  @SWG\Items(ref="#/definitions/CustomerTransaction")
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
        $customerTransactions = $this->customerTransactionRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($customerTransactions->toArray(), 'Customer Transactions retrieved successfully');
    }

    /**
     * @param CreateCustomerTransactionAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/customerTransactions",
     *      summary="Store a newly created CustomerTransaction in storage",
     *      tags={"CustomerTransaction"},
     *      description="Store CustomerTransaction",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CustomerTransaction that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CustomerTransaction")
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
     *                  ref="#/definitions/CustomerTransaction"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCustomerTransactionAPIRequest $request)
    {
        $input = $request->all();

        $customerTransaction = $this->customerTransactionRepository->create($input);

        return $this->sendResponse($customerTransaction->toArray(), 'Customer Transaction saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/customerTransactions/{id}",
     *      summary="Display the specified CustomerTransaction",
     *      tags={"CustomerTransaction"},
     *      description="Get CustomerTransaction",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CustomerTransaction",
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
     *                  ref="#/definitions/CustomerTransaction"
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
        /** @var CustomerTransaction $customerTransaction */
        $customerTransaction = $this->customerTransactionRepository->find($id);

        if (empty($customerTransaction)) {
            return $this->sendError('Customer Transaction not found');
        }

        return $this->sendResponse($customerTransaction->toArray(), 'Customer Transaction retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCustomerTransactionAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/customerTransactions/{id}",
     *      summary="Update the specified CustomerTransaction in storage",
     *      tags={"CustomerTransaction"},
     *      description="Update CustomerTransaction",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CustomerTransaction",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CustomerTransaction that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CustomerTransaction")
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
     *                  ref="#/definitions/CustomerTransaction"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCustomerTransactionAPIRequest $request)
    {
        $input = $request->all();

        /** @var CustomerTransaction $customerTransaction */
        $customerTransaction = $this->customerTransactionRepository->find($id);

        if (empty($customerTransaction)) {
            return $this->sendError('Customer Transaction not found');
        }

        $customerTransaction = $this->customerTransactionRepository->update($input, $id);

        return $this->sendResponse($customerTransaction->toArray(), 'CustomerTransaction updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/customerTransactions/{id}",
     *      summary="Remove the specified CustomerTransaction from storage",
     *      tags={"CustomerTransaction"},
     *      description="Delete CustomerTransaction",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CustomerTransaction",
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
        /** @var CustomerTransaction $customerTransaction */
        $customerTransaction = $this->customerTransactionRepository->find($id);

        if (empty($customerTransaction)) {
            return $this->sendError('Customer Transaction not found');
        }

        $customerTransaction->delete();

        return $this->sendSuccess('Customer Transaction deleted successfully');
    }
}
