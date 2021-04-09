<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCustomerLoanAPIRequest;
use App\Http\Requests\API\UpdateCustomerLoanAPIRequest;
use App\Models\CustomerLoan;
use App\Repositories\CustomerLoanRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CustomerLoanController
 * @package App\Http\Controllers\API
 */

class CustomerLoanAPIController extends AppBaseController
{
    /** @var  CustomerLoanRepository */
    private $customerLoanRepository;

    public function __construct(CustomerLoanRepository $customerLoanRepo)
    {
        $this->customerLoanRepository = $customerLoanRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/customerLoans",
     *      summary="Get a listing of the CustomerLoans.",
     *      tags={"CustomerLoan"},
     *      description="Get all CustomerLoans",
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
     *                  @SWG\Items(ref="#/definitions/CustomerLoan")
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
        $customerLoans = $this->customerLoanRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($customerLoans->toArray(), 'Customer Loans retrieved successfully');
    }

    /**
     * @param CreateCustomerLoanAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/customerLoans",
     *      summary="Store a newly created CustomerLoan in storage",
     *      tags={"CustomerLoan"},
     *      description="Store CustomerLoan",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CustomerLoan that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CustomerLoan")
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
     *                  ref="#/definitions/CustomerLoan"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCustomerLoanAPIRequest $request)
    {
        $input = $request->all();

        $customerLoan = $this->customerLoanRepository->create($input);

        return $this->sendResponse($customerLoan->toArray(), 'Customer Loan saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/customerLoans/{id}",
     *      summary="Display the specified CustomerLoan",
     *      tags={"CustomerLoan"},
     *      description="Get CustomerLoan",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CustomerLoan",
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
     *                  ref="#/definitions/CustomerLoan"
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
        /** @var CustomerLoan $customerLoan */
        $customerLoan = $this->customerLoanRepository->find($id);

        if (empty($customerLoan)) {
            return $this->sendError('Customer Loan not found');
        }

        return $this->sendResponse($customerLoan->toArray(), 'Customer Loan retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCustomerLoanAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/customerLoans/{id}",
     *      summary="Update the specified CustomerLoan in storage",
     *      tags={"CustomerLoan"},
     *      description="Update CustomerLoan",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CustomerLoan",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CustomerLoan that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CustomerLoan")
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
     *                  ref="#/definitions/CustomerLoan"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCustomerLoanAPIRequest $request)
    {
        $input = $request->all();

        /** @var CustomerLoan $customerLoan */
        $customerLoan = $this->customerLoanRepository->find($id);

        if (empty($customerLoan)) {
            return $this->sendError('Customer Loan not found');
        }

        $customerLoan = $this->customerLoanRepository->update($input, $id);

        return $this->sendResponse($customerLoan->toArray(), 'CustomerLoan updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/customerLoans/{id}",
     *      summary="Remove the specified CustomerLoan from storage",
     *      tags={"CustomerLoan"},
     *      description="Delete CustomerLoan",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CustomerLoan",
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
        /** @var CustomerLoan $customerLoan */
        $customerLoan = $this->customerLoanRepository->find($id);

        if (empty($customerLoan)) {
            return $this->sendError('Customer Loan not found');
        }

        $customerLoan->delete();

        return $this->sendSuccess('Customer Loan deleted successfully');
    }
}
