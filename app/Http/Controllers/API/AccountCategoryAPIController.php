<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAccountCategoryAPIRequest;
use App\Http\Requests\API\UpdateAccountCategoryAPIRequest;
use App\Models\AccountCategory;
use App\Repositories\AccountCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AccountCategoryController
 * @package App\Http\Controllers\API
 */

class AccountCategoryAPIController extends AppBaseController
{
    /** @var  AccountCategoryRepository */
    private $accountCategoryRepository;

    public function __construct(AccountCategoryRepository $accountCategoryRepo)
    {
        $this->accountCategoryRepository = $accountCategoryRepo;
    }

    /**
     * Display a listing of the AccountCategory.
     * GET|HEAD /accountCategories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $accountCategories = $this->accountCategoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($accountCategories->toArray(), 'Account Categories retrieved successfully');
    }

    /**
     * Store a newly created AccountCategory in storage.
     * POST /accountCategories
     *
     * @param CreateAccountCategoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAccountCategoryAPIRequest $request)
    {
        $input = $request->all();

        $accountCategory = $this->accountCategoryRepository->create($input);

        return $this->sendResponse($accountCategory->toArray(), 'Account Category saved successfully');
    }

    /**
     * Display the specified AccountCategory.
     * GET|HEAD /accountCategories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AccountCategory $accountCategory */
        $accountCategory = $this->accountCategoryRepository->find($id);

        if (empty($accountCategory)) {
            return $this->sendError('Account Category not found');
        }

        return $this->sendResponse($accountCategory->toArray(), 'Account Category retrieved successfully');
    }

    /**
     * Update the specified AccountCategory in storage.
     * PUT/PATCH /accountCategories/{id}
     *
     * @param int $id
     * @param UpdateAccountCategoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAccountCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var AccountCategory $accountCategory */
        $accountCategory = $this->accountCategoryRepository->find($id);

        if (empty($accountCategory)) {
            return $this->sendError('Account Category not found');
        }

        $accountCategory = $this->accountCategoryRepository->update($input, $id);

        return $this->sendResponse($accountCategory->toArray(), 'AccountCategory updated successfully');
    }

    /**
     * Remove the specified AccountCategory from storage.
     * DELETE /accountCategories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var AccountCategory $accountCategory */
        $accountCategory = $this->accountCategoryRepository->find($id);

        if (empty($accountCategory)) {
            return $this->sendError('Account Category not found');
        }

        $accountCategory->delete();

        return $this->sendSuccess('Account Category deleted successfully');
    }
}
