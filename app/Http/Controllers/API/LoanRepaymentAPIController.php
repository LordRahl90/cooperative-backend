<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLoanRepaymentAPIRequest;
use App\Http\Requests\API\UpdateLoanRepaymentAPIRequest;
use App\Models\LoanRepayment;
use App\Repositories\LoanRepaymentRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class LoanRepaymentController
 * @package App\Http\Controllers\API
 */

class LoanRepaymentAPIController extends AppBaseController
{
    /** @var  LoanRepaymentRepository */
    private $loanRepaymentRepository;

    public function __construct(LoanRepaymentRepository $loanRepaymentRepo)
    {
        $this->loanRepaymentRepository = $loanRepaymentRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/loanRepayments",
     *      summary="Get a listing of the LoanRepayments.",
     *      tags={"LoanRepayment"},
     *      description="Get all LoanRepayments",
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
     *                  @SWG\Items(ref="#/definitions/LoanRepayment")
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
        $loanRepayments = $this->loanRepaymentRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($loanRepayments->toArray(), 'Loan Repayments retrieved successfully');
    }

    /**
     * @param CreateLoanRepaymentAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/loanRepayments",
     *      summary="Store a newly created LoanRepayment in storage",
     *      tags={"LoanRepayment"},
     *      description="Store LoanRepayment",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="LoanRepayment that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/LoanRepayment")
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
     *                  ref="#/definitions/LoanRepayment"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateLoanRepaymentAPIRequest $request)
    {
        $input = $request->all();

        $loanRepayment = $this->loanRepaymentRepository->create($input);

        return $this->sendResponse($loanRepayment->toArray(), 'Loan Repayment saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/loanRepayments/{id}",
     *      summary="Display the specified LoanRepayment",
     *      tags={"LoanRepayment"},
     *      description="Get LoanRepayment",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of LoanRepayment",
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
     *                  ref="#/definitions/LoanRepayment"
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
        /** @var LoanRepayment $loanRepayment */
        $loanRepayment = $this->loanRepaymentRepository->find($id);

        if (empty($loanRepayment)) {
            return $this->sendError('Loan Repayment not found');
        }

        return $this->sendResponse($loanRepayment->toArray(), 'Loan Repayment retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateLoanRepaymentAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/loanRepayments/{id}",
     *      summary="Update the specified LoanRepayment in storage",
     *      tags={"LoanRepayment"},
     *      description="Update LoanRepayment",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of LoanRepayment",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="LoanRepayment that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/LoanRepayment")
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
     *                  ref="#/definitions/LoanRepayment"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateLoanRepaymentAPIRequest $request)
    {
        $input = $request->all();

        /** @var LoanRepayment $loanRepayment */
        $loanRepayment = $this->loanRepaymentRepository->find($id);

        if (empty($loanRepayment)) {
            return $this->sendError('Loan Repayment not found');
        }

        $loanRepayment = $this->loanRepaymentRepository->update($input, $id);

        return $this->sendResponse($loanRepayment->toArray(), 'LoanRepayment updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/loanRepayments/{id}",
     *      summary="Remove the specified LoanRepayment from storage",
     *      tags={"LoanRepayment"},
     *      description="Delete LoanRepayment",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of LoanRepayment",
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
        /** @var LoanRepayment $loanRepayment */
        $loanRepayment = $this->loanRepaymentRepository->find($id);

        if (empty($loanRepayment)) {
            return $this->sendError('Loan Repayment not found');
        }

        $loanRepayment->delete();

        return $this->sendSuccess('Loan Repayment deleted successfully');
    }
}
