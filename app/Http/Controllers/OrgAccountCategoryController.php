<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrgAccountCategoryRequest;
use App\Http\Requests\UpdateOrgAccountCategoryRequest;
use App\Models\Company;
use App\Repositories\OrgAccountCategoryRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class OrgAccountCategoryController extends AppBaseController
{
    /** @var  OrgAccountCategoryRepository */
    private $orgAccountCategoryRepository;

    public function __construct(OrgAccountCategoryRepository $orgAccountCategoryRepo)
    {
        $this->orgAccountCategoryRepository = $orgAccountCategoryRepo;
    }

    /**
     * Display a listing of the OrgAccountCategory.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $companyID = session('company_id');
        $orgAccountCategories = $this->orgAccountCategoryRepository->where("company_id",$companyID);

        return view('org_account_categories.index')
            ->with('orgAccountCategories', $orgAccountCategories);
    }

    /**
     * Show the form for creating a new OrgAccountCategory.
     *
     * @return Response
     */
    public function create()
    {
        $companies = Company::orderBy('name', 'desc')->pluck('name', 'id');
        return view('org_account_categories.create', [
            'companies' => $companies
        ]);
    }

    /**
     * Store a newly created OrgAccountCategory in storage.
     *
     * @param CreateOrgAccountCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateOrgAccountCategoryRequest $request)
    {
        $input = $request->all();

        $orgAccountCategory = $this->orgAccountCategoryRepository->create($input);

        Flash::success('Org Account Category saved successfully.');

        return redirect(route('orgAccountCategories.index'));
    }

    /**
     * Display the specified OrgAccountCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $orgAccountCategory = $this->orgAccountCategoryRepository->find($id);

        if (empty($orgAccountCategory)) {
            Flash::error('Org Account Category not found');

            return redirect(route('orgAccountCategories.index'));
        }

        return view('org_account_categories.show')->with('orgAccountCategory', $orgAccountCategory);
    }

    /**
     * Show the form for editing the specified OrgAccountCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $orgAccountCategory = $this->orgAccountCategoryRepository->find($id);
        $companies = Company::orderBy('name', 'desc')->pluck('name', 'id');

        if (empty($orgAccountCategory)) {
            Flash::error('Org Account Category not found');
            return redirect(route('orgAccountCategories.index'));
        }

        return view('org_account_categories.edit', [
            'companies' => $companies
        ])->with('orgAccountCategory', $orgAccountCategory);
    }

    /**
     * Update the specified OrgAccountCategory in storage.
     *
     * @param int $id
     * @param UpdateOrgAccountCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOrgAccountCategoryRequest $request)
    {
        $orgAccountCategory = $this->orgAccountCategoryRepository->find($id);

        if (empty($orgAccountCategory)) {
            Flash::error('Org Account Category not found');

            return redirect(route('orgAccountCategories.index'));
        }

        $orgAccountCategory = $this->orgAccountCategoryRepository->update($request->all(), $id);

        Flash::success('Org Account Category updated successfully.');

        return redirect(route('orgAccountCategories.index'));
    }

    /**
     * Remove the specified OrgAccountCategory from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $orgAccountCategory = $this->orgAccountCategoryRepository->find($id);

        if (empty($orgAccountCategory)) {
            Flash::error('Org Account Category not found');

            return redirect(route('orgAccountCategories.index'));
        }

        $this->orgAccountCategoryRepository->delete($id);

        Flash::success('Org Account Category deleted successfully.');

        return redirect(route('orgAccountCategories.index'));
    }
}
