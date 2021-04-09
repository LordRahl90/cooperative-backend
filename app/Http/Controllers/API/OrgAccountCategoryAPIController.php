<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateOrgAccountCategoryAPIRequest;
use App\Http\Requests\API\UpdateOrgAccountCategoryAPIRequest;
use App\Models\OrgAccountCategory;
use App\Repositories\OrgAccountCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class OrgAccountCategoryController
 * @package App\Http\Controllers\API
 */

class OrgAccountCategoryAPIController extends AppBaseController
{
    /** @var  OrgAccountCategoryRepository */
    private $orgAccountCategoryRepository;

    public function __construct(OrgAccountCategoryRepository $orgAccountCategoryRepo)
    {
        $this->orgAccountCategoryRepository = $orgAccountCategoryRepo;
    }

    /**
     * Display a listing of the OrgAccountCategory.
     * GET|HEAD /orgAccountCategories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $orgAccountCategories = $this->orgAccountCategoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($orgAccountCategories->toArray(), 'Org Account Categories retrieved successfully');
    }

    /**
     * Store a newly created OrgAccountCategory in storage.
     * POST /orgAccountCategories
     *
     * @param CreateOrgAccountCategoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateOrgAccountCategoryAPIRequest $request)
    {
        $input = $request->all();

        $orgAccountCategory = $this->orgAccountCategoryRepository->create($input);

        return $this->sendResponse($orgAccountCategory->toArray(), 'Org Account Category saved successfully');
    }

    /**
     * Display the specified OrgAccountCategory.
     * GET|HEAD /orgAccountCategories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var OrgAccountCategory $orgAccountCategory */
        $orgAccountCategory = $this->orgAccountCategoryRepository->find($id);

        if (empty($orgAccountCategory)) {
            return $this->sendError('Org Account Category not found');
        }

        return $this->sendResponse($orgAccountCategory->toArray(), 'Org Account Category retrieved successfully');
    }

    /**
     * Update the specified OrgAccountCategory in storage.
     * PUT/PATCH /orgAccountCategories/{id}
     *
     * @param int $id
     * @param UpdateOrgAccountCategoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOrgAccountCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var OrgAccountCategory $orgAccountCategory */
        $orgAccountCategory = $this->orgAccountCategoryRepository->find($id);

        if (empty($orgAccountCategory)) {
            return $this->sendError('Org Account Category not found');
        }

        $orgAccountCategory = $this->orgAccountCategoryRepository->update($input, $id);

        return $this->sendResponse($orgAccountCategory->toArray(), 'OrgAccountCategory updated successfully');
    }

    /**
     * Remove the specified OrgAccountCategory from storage.
     * DELETE /orgAccountCategories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var OrgAccountCategory $orgAccountCategory */
        $orgAccountCategory = $this->orgAccountCategoryRepository->find($id);

        if (empty($orgAccountCategory)) {
            return $this->sendError('Org Account Category not found');
        }

        $orgAccountCategory->delete();

        return $this->sendSuccess('Org Account Category deleted successfully');
    }
}
