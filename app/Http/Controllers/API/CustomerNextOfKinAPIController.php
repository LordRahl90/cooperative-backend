<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCustomerNextOfKinAPIRequest;
use App\Http\Requests\API\UpdateCustomerNextOfKinAPIRequest;
use App\Models\CustomerNextOfKin;
use App\Repositories\CustomerNextOfKinRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CustomerNextOfKinController
 * @package App\Http\Controllers\API
 */

class CustomerNextOfKinAPIController extends AppBaseController
{
    /** @var  CustomerNextOfKinRepository */
    private $customerNextOfKinRepository;

    public function __construct(CustomerNextOfKinRepository $customerNextOfKinRepo)
    {
        $this->customerNextOfKinRepository = $customerNextOfKinRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/customerNextOfKins",
     *      summary="Get a listing of the CustomerNextOfKins.",
     *      tags={"CustomerNextOfKin"},
     *      description="Get all CustomerNextOfKins",
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
     *                  @SWG\Items(ref="#/definitions/CustomerNextOfKin")
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
        $customerNextOfKins = $this->customerNextOfKinRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($customerNextOfKins->toArray(), 'Customer Next Of Kins retrieved successfully');
    }

    /**
     * @param CreateCustomerNextOfKinAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/customerNextOfKins",
     *      summary="Store a newly created CustomerNextOfKin in storage",
     *      tags={"CustomerNextOfKin"},
     *      description="Store CustomerNextOfKin",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CustomerNextOfKin that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CustomerNextOfKin")
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
     *                  ref="#/definitions/CustomerNextOfKin"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCustomerNextOfKinAPIRequest $request)
    {
        $input = $request->all();

        $customerNextOfKin = $this->customerNextOfKinRepository->create($input);

        return $this->sendResponse($customerNextOfKin->toArray(), 'Customer Next Of Kin saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/customerNextOfKins/{id}",
     *      summary="Display the specified CustomerNextOfKin",
     *      tags={"CustomerNextOfKin"},
     *      description="Get CustomerNextOfKin",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CustomerNextOfKin",
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
     *                  ref="#/definitions/CustomerNextOfKin"
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
        /** @var CustomerNextOfKin $customerNextOfKin */
        $customerNextOfKin = $this->customerNextOfKinRepository->find($id);

        if (empty($customerNextOfKin)) {
            return $this->sendError('Customer Next Of Kin not found');
        }

        return $this->sendResponse($customerNextOfKin->toArray(), 'Customer Next Of Kin retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCustomerNextOfKinAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/customerNextOfKins/{id}",
     *      summary="Update the specified CustomerNextOfKin in storage",
     *      tags={"CustomerNextOfKin"},
     *      description="Update CustomerNextOfKin",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CustomerNextOfKin",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CustomerNextOfKin that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CustomerNextOfKin")
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
     *                  ref="#/definitions/CustomerNextOfKin"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCustomerNextOfKinAPIRequest $request)
    {
        $input = $request->all();

        /** @var CustomerNextOfKin $customerNextOfKin */
        $customerNextOfKin = $this->customerNextOfKinRepository->find($id);

        if (empty($customerNextOfKin)) {
            return $this->sendError('Customer Next Of Kin not found');
        }

        $customerNextOfKin = $this->customerNextOfKinRepository->update($input, $id);

        return $this->sendResponse($customerNextOfKin->toArray(), 'CustomerNextOfKin updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/customerNextOfKins/{id}",
     *      summary="Remove the specified CustomerNextOfKin from storage",
     *      tags={"CustomerNextOfKin"},
     *      description="Delete CustomerNextOfKin",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CustomerNextOfKin",
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
        /** @var CustomerNextOfKin $customerNextOfKin */
        $customerNextOfKin = $this->customerNextOfKinRepository->find($id);

        if (empty($customerNextOfKin)) {
            return $this->sendError('Customer Next Of Kin not found');
        }

        $customerNextOfKin->delete();

        return $this->sendSuccess('Customer Next Of Kin deleted successfully');
    }
}
