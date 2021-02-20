<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCustomerBankAccountAPIRequest;
use App\Http\Requests\API\UpdateCustomerBankAccountAPIRequest;
use App\Models\CustomerBankAccount;
use App\Repositories\CustomerBankAccountRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CustomerBankAccountController
 * @package App\Http\Controllers\API
 */

class CustomerBankAccountAPIController extends AppBaseController
{
    /** @var  CustomerBankAccountRepository */
    private $customerBankAccountRepository;

    public function __construct(CustomerBankAccountRepository $customerBankAccountRepo)
    {
        $this->customerBankAccountRepository = $customerBankAccountRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/customerBankAccounts",
     *      summary="Get a listing of the CustomerBankAccounts.",
     *      tags={"CustomerBankAccount"},
     *      description="Get all CustomerBankAccounts",
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
     *                  @SWG\Items(ref="#/definitions/CustomerBankAccount")
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
        $customerBankAccounts = $this->customerBankAccountRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($customerBankAccounts->toArray(), 'Customer Bank Accounts retrieved successfully');
    }

    /**
     * @param CreateCustomerBankAccountAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/customerBankAccounts",
     *      summary="Store a newly created CustomerBankAccount in storage",
     *      tags={"CustomerBankAccount"},
     *      description="Store CustomerBankAccount",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CustomerBankAccount that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CustomerBankAccount")
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
     *                  ref="#/definitions/CustomerBankAccount"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCustomerBankAccountAPIRequest $request)
    {
        $input = $request->all();

        $customerBankAccount = $this->customerBankAccountRepository->create($input);

        return $this->sendResponse($customerBankAccount->toArray(), 'Customer Bank Account saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/customerBankAccounts/{id}",
     *      summary="Display the specified CustomerBankAccount",
     *      tags={"CustomerBankAccount"},
     *      description="Get CustomerBankAccount",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CustomerBankAccount",
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
     *                  ref="#/definitions/CustomerBankAccount"
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
        /** @var CustomerBankAccount $customerBankAccount */
        $customerBankAccount = $this->customerBankAccountRepository->find($id);

        if (empty($customerBankAccount)) {
            return $this->sendError('Customer Bank Account not found');
        }

        return $this->sendResponse($customerBankAccount->toArray(), 'Customer Bank Account retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCustomerBankAccountAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/customerBankAccounts/{id}",
     *      summary="Update the specified CustomerBankAccount in storage",
     *      tags={"CustomerBankAccount"},
     *      description="Update CustomerBankAccount",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CustomerBankAccount",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CustomerBankAccount that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CustomerBankAccount")
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
     *                  ref="#/definitions/CustomerBankAccount"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCustomerBankAccountAPIRequest $request)
    {
        $input = $request->all();

        /** @var CustomerBankAccount $customerBankAccount */
        $customerBankAccount = $this->customerBankAccountRepository->find($id);

        if (empty($customerBankAccount)) {
            return $this->sendError('Customer Bank Account not found');
        }

        $customerBankAccount = $this->customerBankAccountRepository->update($input, $id);

        return $this->sendResponse($customerBankAccount->toArray(), 'CustomerBankAccount updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/customerBankAccounts/{id}",
     *      summary="Remove the specified CustomerBankAccount from storage",
     *      tags={"CustomerBankAccount"},
     *      description="Delete CustomerBankAccount",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CustomerBankAccount",
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
        /** @var CustomerBankAccount $customerBankAccount */
        $customerBankAccount = $this->customerBankAccountRepository->find($id);

        if (empty($customerBankAccount)) {
            return $this->sendError('Customer Bank Account not found');
        }

        $customerBankAccount->delete();

        return $this->sendSuccess('Customer Bank Account deleted successfully');
    }
}
