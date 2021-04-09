<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLoanCategoryAPIRequest;
use App\Http\Requests\API\UpdateLoanCategoryAPIRequest;
use App\Models\LoanCategory;
use App\Models\OrgAccountHead;
use App\Repositories\LoanCategoryRepository;
use App\Utility\Utility;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class LoanCategoryController
 * @package App\Http\Controllers\API
 */
class LoanCategoryAPIController extends AppBaseController
{
    /** @var  LoanCategoryRepository */
    private $loanCategoryRepository;

    public function __construct(LoanCategoryRepository $loanCategoryRepo)
    {
        $this->loanCategoryRepository = $loanCategoryRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/loanCategories",
     *      summary="Get a listing of the LoanCategories.",
     *      tags={"LoanCategory"},
     *      description="Get all LoanCategories",
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
     *                  @SWG\Items(ref="#/definitions/LoanCategory")
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
        $loanCategories = $this->loanCategoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($loanCategories->toArray(), 'Loan Categories retrieved successfully');
    }

    /**
     * @param CreateLoanCategoryAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/loanCategories",
     *      summary="Store a newly created LoanCategory in storage",
     *      tags={"LoanCategory"},
     *      description="Store LoanCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="LoanCategory that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/LoanCategory")
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
     *                  ref="#/definitions/LoanCategory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateLoanCategoryAPIRequest $request)
    {
        $input = $request->all();

        $loanCategory = $this->loanCategoryRepository->create($input);

        return $this->sendResponse($loanCategory->toArray(), 'Loan Category saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/loanCategories/{id}",
     *      summary="Display the specified LoanCategory",
     *      tags={"LoanCategory"},
     *      description="Get LoanCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of LoanCategory",
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
     *                  ref="#/definitions/LoanCategory"
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
        /** @var LoanCategory $loanCategory */
        $loanCategory = $this->loanCategoryRepository->find($id);

        if (empty($loanCategory)) {
            return $this->sendError('Loan Category not found');
        }

        return $this->sendResponse($loanCategory->toArray(), 'Loan Category retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateLoanCategoryAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/loanCategories/{id}",
     *      summary="Update the specified LoanCategory in storage",
     *      tags={"LoanCategory"},
     *      description="Update LoanCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of LoanCategory",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="LoanCategory that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/LoanCategory")
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
     *                  ref="#/definitions/LoanCategory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateLoanCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var LoanCategory $loanCategory */
        $loanCategory = $this->loanCategoryRepository->find($id);

        if (empty($loanCategory)) {
            return $this->sendError('Loan Category not found');
        }

        $loanCategory = $this->loanCategoryRepository->update($input, $id);

        return $this->sendResponse($loanCategory->toArray(), 'LoanCategory updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/loanCategories/{id}",
     *      summary="Remove the specified LoanCategory from storage",
     *      tags={"LoanCategory"},
     *      description="Delete LoanCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of LoanCategory",
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
        /** @var LoanCategory $loanCategory */
        $loanCategory = $this->loanCategoryRepository->find($id);

        if (empty($loanCategory)) {
            return $this->sendError('Loan Category not found');
        }

        $loanCategory->delete();

        return $this->sendSuccess('Loan Category deleted successfully');
    }

    public function loadCategoryAccount($categoryID, Request $request)
    {
        $loanCategory = LoanCategory::find($categoryID);
        $accountHeads = OrgAccountHead::where('category_id', $loanCategory->category_id)
            ->doesntHave('bank_account')
            ->pluck('name', 'id')->toArray();
        return $this->sendResponse($accountHeads, 'hello world');
    }
}
