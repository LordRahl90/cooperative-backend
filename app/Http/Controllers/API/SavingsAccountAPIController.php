<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSavingsAccountAPIRequest;
use App\Http\Requests\API\UpdateSavingsAccountAPIRequest;
use App\Models\SavingsAccount;
use App\Repositories\SavingsAccountRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class SavingsAccountController
 * @package App\Http\Controllers\API
 */

class SavingsAccountAPIController extends AppBaseController
{
    /** @var  SavingsAccountRepository */
    private $savingsAccountRepository;

    public function __construct(SavingsAccountRepository $savingsAccountRepo)
    {
        $this->savingsAccountRepository = $savingsAccountRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/savingsAccounts",
     *      summary="Get a listing of the SavingsAccounts.",
     *      tags={"SavingsAccount"},
     *      description="Get all SavingsAccounts",
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
     *                  @SWG\Items(ref="#/definitions/SavingsAccount")
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
        $savingsAccounts = $this->savingsAccountRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($savingsAccounts->toArray(), 'Savings Accounts retrieved successfully');
    }

    /**
     * @param CreateSavingsAccountAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/savingsAccounts",
     *      summary="Store a newly created SavingsAccount in storage",
     *      tags={"SavingsAccount"},
     *      description="Store SavingsAccount",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SavingsAccount that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SavingsAccount")
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
     *                  ref="#/definitions/SavingsAccount"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSavingsAccountAPIRequest $request)
    {
        $input = $request->all();

        $savingsAccount = $this->savingsAccountRepository->create($input);

        return $this->sendResponse($savingsAccount->toArray(), 'Savings Account saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/savingsAccounts/{id}",
     *      summary="Display the specified SavingsAccount",
     *      tags={"SavingsAccount"},
     *      description="Get SavingsAccount",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SavingsAccount",
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
     *                  ref="#/definitions/SavingsAccount"
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
        /** @var SavingsAccount $savingsAccount */
        $savingsAccount = $this->savingsAccountRepository->find($id);

        if (empty($savingsAccount)) {
            return $this->sendError('Savings Account not found');
        }

        return $this->sendResponse($savingsAccount->toArray(), 'Savings Account retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSavingsAccountAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/savingsAccounts/{id}",
     *      summary="Update the specified SavingsAccount in storage",
     *      tags={"SavingsAccount"},
     *      description="Update SavingsAccount",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SavingsAccount",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SavingsAccount that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SavingsAccount")
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
     *                  ref="#/definitions/SavingsAccount"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSavingsAccountAPIRequest $request)
    {
        $input = $request->all();

        /** @var SavingsAccount $savingsAccount */
        $savingsAccount = $this->savingsAccountRepository->find($id);

        if (empty($savingsAccount)) {
            return $this->sendError('Savings Account not found');
        }

        $savingsAccount = $this->savingsAccountRepository->update($input, $id);

        return $this->sendResponse($savingsAccount->toArray(), 'SavingsAccount updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/savingsAccounts/{id}",
     *      summary="Remove the specified SavingsAccount from storage",
     *      tags={"SavingsAccount"},
     *      description="Delete SavingsAccount",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SavingsAccount",
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
        /** @var SavingsAccount $savingsAccount */
        $savingsAccount = $this->savingsAccountRepository->find($id);

        if (empty($savingsAccount)) {
            return $this->sendError('Savings Account not found');
        }

        $savingsAccount->delete();

        return $this->sendSuccess('Savings Account deleted successfully');
    }
}
