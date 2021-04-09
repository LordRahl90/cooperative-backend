<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCustomerSavingAPIRequest;
use App\Http\Requests\API\UpdateCustomerSavingAPIRequest;
use App\Models\CustomerSaving;
use App\Repositories\CustomerSavingRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CustomerSavingController
 * @package App\Http\Controllers\API
 */

class CustomerSavingAPIController extends AppBaseController
{
    /** @var  CustomerSavingRepository */
    private $customerSavingRepository;

    public function __construct(CustomerSavingRepository $customerSavingRepo)
    {
        $this->customerSavingRepository = $customerSavingRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/customerSavings",
     *      summary="Get a listing of the CustomerSavings.",
     *      tags={"CustomerSaving"},
     *      description="Get all CustomerSavings",
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
     *                  @SWG\Items(ref="#/definitions/CustomerSaving")
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
        $customerSavings = $this->customerSavingRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($customerSavings->toArray(), 'Customer Savings retrieved successfully');
    }

    /**
     * @param CreateCustomerSavingAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/customerSavings",
     *      summary="Store a newly created CustomerSaving in storage",
     *      tags={"CustomerSaving"},
     *      description="Store CustomerSaving",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CustomerSaving that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CustomerSaving")
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
     *                  ref="#/definitions/CustomerSaving"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCustomerSavingAPIRequest $request)
    {
        $input = $request->all();

        $customerSaving = $this->customerSavingRepository->create($input);

        return $this->sendResponse($customerSaving->toArray(), 'Customer Saving saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/customerSavings/{id}",
     *      summary="Display the specified CustomerSaving",
     *      tags={"CustomerSaving"},
     *      description="Get CustomerSaving",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CustomerSaving",
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
     *                  ref="#/definitions/CustomerSaving"
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
        /** @var CustomerSaving $customerSaving */
        $customerSaving = $this->customerSavingRepository->find($id);

        if (empty($customerSaving)) {
            return $this->sendError('Customer Saving not found');
        }

        return $this->sendResponse($customerSaving->toArray(), 'Customer Saving retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCustomerSavingAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/customerSavings/{id}",
     *      summary="Update the specified CustomerSaving in storage",
     *      tags={"CustomerSaving"},
     *      description="Update CustomerSaving",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CustomerSaving",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CustomerSaving that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CustomerSaving")
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
     *                  ref="#/definitions/CustomerSaving"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCustomerSavingAPIRequest $request)
    {
        $input = $request->all();

        /** @var CustomerSaving $customerSaving */
        $customerSaving = $this->customerSavingRepository->find($id);

        if (empty($customerSaving)) {
            return $this->sendError('Customer Saving not found');
        }

        $customerSaving = $this->customerSavingRepository->update($input, $id);

        return $this->sendResponse($customerSaving->toArray(), 'CustomerSaving updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/customerSavings/{id}",
     *      summary="Remove the specified CustomerSaving from storage",
     *      tags={"CustomerSaving"},
     *      description="Delete CustomerSaving",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CustomerSaving",
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
        /** @var CustomerSaving $customerSaving */
        $customerSaving = $this->customerSavingRepository->find($id);

        if (empty($customerSaving)) {
            return $this->sendError('Customer Saving not found');
        }

        $customerSaving->delete();

        return $this->sendSuccess('Customer Saving deleted successfully');
    }
}
