<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLoanAccountAPIRequest;
use App\Http\Requests\API\UpdateLoanAccountAPIRequest;
use App\Models\LoanAccount;
use App\Repositories\LoanAccountRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class LoanAccountController
 * @package App\Http\Controllers\API
 */

class LoanAccountAPIController extends AppBaseController
{
    /** @var  LoanAccountRepository */
    private $loanAccountRepository;

    public function __construct(LoanAccountRepository $loanAccountRepo)
    {
        $this->loanAccountRepository = $loanAccountRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/loanAccounts",
     *      summary="Get a listing of the LoanAccounts.",
     *      tags={"LoanAccount"},
     *      description="Get all LoanAccounts",
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
     *                  @SWG\Items(ref="#/definitions/LoanAccount")
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
        $loanAccounts = $this->loanAccountRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($loanAccounts->toArray(), 'Loan Accounts retrieved successfully');
    }

    /**
     * @param CreateLoanAccountAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/loanAccounts",
     *      summary="Store a newly created LoanAccount in storage",
     *      tags={"LoanAccount"},
     *      description="Store LoanAccount",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="LoanAccount that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/LoanAccount")
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
     *                  ref="#/definitions/LoanAccount"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateLoanAccountAPIRequest $request)
    {
        $input = $request->all();

        $loanAccount = $this->loanAccountRepository->create($input);

        return $this->sendResponse($loanAccount->toArray(), 'Loan Account saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/loanAccounts/{id}",
     *      summary="Display the specified LoanAccount",
     *      tags={"LoanAccount"},
     *      description="Get LoanAccount",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of LoanAccount",
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
     *                  ref="#/definitions/LoanAccount"
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
        /** @var LoanAccount $loanAccount */
        $loanAccount = $this->loanAccountRepository->find($id);

        if (empty($loanAccount)) {
            return $this->sendError('Loan Account not found');
        }

        return $this->sendResponse($loanAccount->toArray(), 'Loan Account retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateLoanAccountAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/loanAccounts/{id}",
     *      summary="Update the specified LoanAccount in storage",
     *      tags={"LoanAccount"},
     *      description="Update LoanAccount",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of LoanAccount",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="LoanAccount that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/LoanAccount")
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
     *                  ref="#/definitions/LoanAccount"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateLoanAccountAPIRequest $request)
    {
        $input = $request->all();

        /** @var LoanAccount $loanAccount */
        $loanAccount = $this->loanAccountRepository->find($id);

        if (empty($loanAccount)) {
            return $this->sendError('Loan Account not found');
        }

        $loanAccount = $this->loanAccountRepository->update($input, $id);

        return $this->sendResponse($loanAccount->toArray(), 'LoanAccount updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/loanAccounts/{id}",
     *      summary="Remove the specified LoanAccount from storage",
     *      tags={"LoanAccount"},
     *      description="Delete LoanAccount",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of LoanAccount",
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
        /** @var LoanAccount $loanAccount */
        $loanAccount = $this->loanAccountRepository->find($id);

        if (empty($loanAccount)) {
            return $this->sendError('Loan Account not found');
        }

        $loanAccount->delete();

        return $this->sendSuccess('Loan Account deleted successfully');
    }
}
