<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLoanGuaratorAPIRequest;
use App\Http\Requests\API\UpdateLoanGuaratorAPIRequest;
use App\Models\LoanGuarator;
use App\Repositories\LoanGuaratorRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class LoanGuaratorController
 * @package App\Http\Controllers\API
 */

class LoanGuaratorAPIController extends AppBaseController
{
    /** @var  LoanGuaratorRepository */
    private $loanGuaratorRepository;

    public function __construct(LoanGuaratorRepository $loanGuaratorRepo)
    {
        $this->loanGuaratorRepository = $loanGuaratorRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/loanGuarators",
     *      summary="Get a listing of the LoanGuarators.",
     *      tags={"LoanGuarator"},
     *      description="Get all LoanGuarators",
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
     *                  @SWG\Items(ref="#/definitions/LoanGuarator")
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
        $loanGuarators = $this->loanGuaratorRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($loanGuarators->toArray(), 'Loan Guarators retrieved successfully');
    }

    /**
     * @param CreateLoanGuaratorAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/loanGuarators",
     *      summary="Store a newly created LoanGuarator in storage",
     *      tags={"LoanGuarator"},
     *      description="Store LoanGuarator",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="LoanGuarator that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/LoanGuarator")
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
     *                  ref="#/definitions/LoanGuarator"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateLoanGuaratorAPIRequest $request)
    {
        $input = $request->all();

        $loanGuarator = $this->loanGuaratorRepository->create($input);

        return $this->sendResponse($loanGuarator->toArray(), 'Loan Guarator saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/loanGuarators/{id}",
     *      summary="Display the specified LoanGuarator",
     *      tags={"LoanGuarator"},
     *      description="Get LoanGuarator",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of LoanGuarator",
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
     *                  ref="#/definitions/LoanGuarator"
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
        /** @var LoanGuarator $loanGuarator */
        $loanGuarator = $this->loanGuaratorRepository->find($id);

        if (empty($loanGuarator)) {
            return $this->sendError('Loan Guarator not found');
        }

        return $this->sendResponse($loanGuarator->toArray(), 'Loan Guarator retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateLoanGuaratorAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/loanGuarators/{id}",
     *      summary="Update the specified LoanGuarator in storage",
     *      tags={"LoanGuarator"},
     *      description="Update LoanGuarator",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of LoanGuarator",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="LoanGuarator that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/LoanGuarator")
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
     *                  ref="#/definitions/LoanGuarator"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateLoanGuaratorAPIRequest $request)
    {
        $input = $request->all();

        /** @var LoanGuarator $loanGuarator */
        $loanGuarator = $this->loanGuaratorRepository->find($id);

        if (empty($loanGuarator)) {
            return $this->sendError('Loan Guarator not found');
        }

        $loanGuarator = $this->loanGuaratorRepository->update($input, $id);

        return $this->sendResponse($loanGuarator->toArray(), 'LoanGuarator updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/loanGuarators/{id}",
     *      summary="Remove the specified LoanGuarator from storage",
     *      tags={"LoanGuarator"},
     *      description="Delete LoanGuarator",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of LoanGuarator",
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
        /** @var LoanGuarator $loanGuarator */
        $loanGuarator = $this->loanGuaratorRepository->find($id);

        if (empty($loanGuarator)) {
            return $this->sendError('Loan Guarator not found');
        }

        $loanGuarator->delete();

        return $this->sendSuccess('Loan Guarator deleted successfully');
    }
}
