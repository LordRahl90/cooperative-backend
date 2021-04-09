<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSavingsCategoryAPIRequest;
use App\Http\Requests\API\UpdateSavingsCategoryAPIRequest;
use App\Models\LoanCategory;
use App\Models\OrgAccountHead;
use App\Models\SavingsCategory;
use App\Repositories\SavingsCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class SavingsCategoryController
 * @package App\Http\Controllers\API
 */
class SavingsCategoryAPIController extends AppBaseController
{
    /** @var  SavingsCategoryRepository */
    private $savingsCategoryRepository;

    public function __construct(SavingsCategoryRepository $savingsCategoryRepo)
    {
        $this->savingsCategoryRepository = $savingsCategoryRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/savingsCategories",
     *      summary="Get a listing of the SavingsCategories.",
     *      tags={"SavingsCategory"},
     *      description="Get all SavingsCategories",
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
     *                  @SWG\Items(ref="#/definitions/SavingsCategory")
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
        $savingsCategories = $this->savingsCategoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($savingsCategories->toArray(), 'Savings Categories retrieved successfully');
    }

    /**
     * @param CreateSavingsCategoryAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/savingsCategories",
     *      summary="Store a newly created SavingsCategory in storage",
     *      tags={"SavingsCategory"},
     *      description="Store SavingsCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SavingsCategory that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SavingsCategory")
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
     *                  ref="#/definitions/SavingsCategory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSavingsCategoryAPIRequest $request)
    {
        $input = $request->all();

        $savingsCategory = $this->savingsCategoryRepository->create($input);

        return $this->sendResponse($savingsCategory->toArray(), 'Savings Category saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/savingsCategories/{id}",
     *      summary="Display the specified SavingsCategory",
     *      tags={"SavingsCategory"},
     *      description="Get SavingsCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SavingsCategory",
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
     *                  ref="#/definitions/SavingsCategory"
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
        /** @var SavingsCategory $savingsCategory */
        $savingsCategory = $this->savingsCategoryRepository->find($id);

        if (empty($savingsCategory)) {
            return $this->sendError('Savings Category not found');
        }

        return $this->sendResponse($savingsCategory->toArray(), 'Savings Category retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSavingsCategoryAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/savingsCategories/{id}",
     *      summary="Update the specified SavingsCategory in storage",
     *      tags={"SavingsCategory"},
     *      description="Update SavingsCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SavingsCategory",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SavingsCategory that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SavingsCategory")
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
     *                  ref="#/definitions/SavingsCategory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSavingsCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var SavingsCategory $savingsCategory */
        $savingsCategory = $this->savingsCategoryRepository->find($id);

        if (empty($savingsCategory)) {
            return $this->sendError('Savings Category not found');
        }

        $savingsCategory = $this->savingsCategoryRepository->update($input, $id);

        return $this->sendResponse($savingsCategory->toArray(), 'SavingsCategory updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/savingsCategories/{id}",
     *      summary="Remove the specified SavingsCategory from storage",
     *      tags={"SavingsCategory"},
     *      description="Delete SavingsCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SavingsCategory",
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
        /** @var SavingsCategory $savingsCategory */
        $savingsCategory = $this->savingsCategoryRepository->find($id);

        if (empty($savingsCategory)) {
            return $this->sendError('Savings Category not found');
        }

        $savingsCategory->delete();

        return $this->sendSuccess('Savings Category deleted successfully');
    }

    public function loadCategoryAccount($categoryID, Request $request)
    {
        $loanCategory = SavingsCategory::find($categoryID);
        $accountHeads = OrgAccountHead::where('category_id', $loanCategory->category_id)->pluck('name', 'id')->toArray();
        return $this->sendResponse($accountHeads, 'hello world');
    }
}
