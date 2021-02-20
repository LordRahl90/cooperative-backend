<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCustomerAddressAPIRequest;
use App\Http\Requests\API\UpdateCustomerAddressAPIRequest;
use App\Models\CustomerAddress;
use App\Repositories\CustomerAddressRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CustomerAddressController
 * @package App\Http\Controllers\API
 */

class CustomerAddressAPIController extends AppBaseController
{
    /** @var  CustomerAddressRepository */
    private $customerAddressRepository;

    public function __construct(CustomerAddressRepository $customerAddressRepo)
    {
        $this->customerAddressRepository = $customerAddressRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/customerAddresses",
     *      summary="Get a listing of the CustomerAddresses.",
     *      tags={"CustomerAddress"},
     *      description="Get all CustomerAddresses",
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
     *                  @SWG\Items(ref="#/definitions/CustomerAddress")
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
        $customerAddresses = $this->customerAddressRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($customerAddresses->toArray(), 'Customer Addresses retrieved successfully');
    }

    /**
     * @param CreateCustomerAddressAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/customerAddresses",
     *      summary="Store a newly created CustomerAddress in storage",
     *      tags={"CustomerAddress"},
     *      description="Store CustomerAddress",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CustomerAddress that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CustomerAddress")
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
     *                  ref="#/definitions/CustomerAddress"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCustomerAddressAPIRequest $request)
    {
        $input = $request->all();

        $customerAddress = $this->customerAddressRepository->create($input);

        return $this->sendResponse($customerAddress->toArray(), 'Customer Address saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/customerAddresses/{id}",
     *      summary="Display the specified CustomerAddress",
     *      tags={"CustomerAddress"},
     *      description="Get CustomerAddress",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CustomerAddress",
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
     *                  ref="#/definitions/CustomerAddress"
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
        /** @var CustomerAddress $customerAddress */
        $customerAddress = $this->customerAddressRepository->find($id);

        if (empty($customerAddress)) {
            return $this->sendError('Customer Address not found');
        }

        return $this->sendResponse($customerAddress->toArray(), 'Customer Address retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCustomerAddressAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/customerAddresses/{id}",
     *      summary="Update the specified CustomerAddress in storage",
     *      tags={"CustomerAddress"},
     *      description="Update CustomerAddress",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CustomerAddress",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CustomerAddress that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CustomerAddress")
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
     *                  ref="#/definitions/CustomerAddress"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCustomerAddressAPIRequest $request)
    {
        $input = $request->all();

        /** @var CustomerAddress $customerAddress */
        $customerAddress = $this->customerAddressRepository->find($id);

        if (empty($customerAddress)) {
            return $this->sendError('Customer Address not found');
        }

        $customerAddress = $this->customerAddressRepository->update($input, $id);

        return $this->sendResponse($customerAddress->toArray(), 'CustomerAddress updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/customerAddresses/{id}",
     *      summary="Remove the specified CustomerAddress from storage",
     *      tags={"CustomerAddress"},
     *      description="Delete CustomerAddress",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CustomerAddress",
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
        /** @var CustomerAddress $customerAddress */
        $customerAddress = $this->customerAddressRepository->find($id);

        if (empty($customerAddress)) {
            return $this->sendError('Customer Address not found');
        }

        $customerAddress->delete();

        return $this->sendSuccess('Customer Address deleted successfully');
    }
}
