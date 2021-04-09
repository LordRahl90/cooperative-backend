<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLoanApplicationAPIRequest;
use App\Http\Requests\API\UpdateLoanApplicationAPIRequest;
use App\Models\LoanApplication;
use App\Repositories\LoanApplicationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class LoanApplicationController
 * @package App\Http\Controllers\API
 */

class LoanApplicationAPIController extends AppBaseController
{
    /** @var  LoanApplicationRepository */
    private $loanApplicationRepository;

    public function __construct(LoanApplicationRepository $loanApplicationRepo)
    {
        $this->loanApplicationRepository = $loanApplicationRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/loanApplications",
     *      summary="Get a listing of the LoanApplications.",
     *      tags={"LoanApplication"},
     *      description="Get all LoanApplications",
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
     *                  @SWG\Items(ref="#/definitions/LoanApplication")
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
        $loanApplications = $this->loanApplicationRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($loanApplications->toArray(), 'Loan Applications retrieved successfully');
    }

    /**
     * @param CreateLoanApplicationAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/loanApplications",
     *      summary="Store a newly created LoanApplication in storage",
     *      tags={"LoanApplication"},
     *      description="Store LoanApplication",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="LoanApplication that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/LoanApplication")
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
     *                  ref="#/definitions/LoanApplication"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateLoanApplicationAPIRequest $request)
    {
        $input = $request->all();

        $loanApplication = $this->loanApplicationRepository->create($input);

        return $this->sendResponse($loanApplication->toArray(), 'Loan Application saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/loanApplications/{id}",
     *      summary="Display the specified LoanApplication",
     *      tags={"LoanApplication"},
     *      description="Get LoanApplication",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of LoanApplication",
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
     *                  ref="#/definitions/LoanApplication"
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
        /** @var LoanApplication $loanApplication */
        $loanApplication = $this->loanApplicationRepository->find($id);

        if (empty($loanApplication)) {
            return $this->sendError('Loan Application not found');
        }

        return $this->sendResponse($loanApplication->toArray(), 'Loan Application retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateLoanApplicationAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/loanApplications/{id}",
     *      summary="Update the specified LoanApplication in storage",
     *      tags={"LoanApplication"},
     *      description="Update LoanApplication",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of LoanApplication",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="LoanApplication that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/LoanApplication")
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
     *                  ref="#/definitions/LoanApplication"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateLoanApplicationAPIRequest $request)
    {
        $input = $request->all();

        /** @var LoanApplication $loanApplication */
        $loanApplication = $this->loanApplicationRepository->find($id);

        if (empty($loanApplication)) {
            return $this->sendError('Loan Application not found');
        }

        $loanApplication = $this->loanApplicationRepository->update($input, $id);

        return $this->sendResponse($loanApplication->toArray(), 'LoanApplication updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/loanApplications/{id}",
     *      summary="Remove the specified LoanApplication from storage",
     *      tags={"LoanApplication"},
     *      description="Delete LoanApplication",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of LoanApplication",
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
        /** @var LoanApplication $loanApplication */
        $loanApplication = $this->loanApplicationRepository->find($id);

        if (empty($loanApplication)) {
            return $this->sendError('Loan Application not found');
        }

        $loanApplication->delete();

        return $this->sendSuccess('Loan Application deleted successfully');
    }
}
