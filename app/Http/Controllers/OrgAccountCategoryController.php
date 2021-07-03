<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrgAccountCategoryRequest;
use App\Http\Requests\UpdateOrgAccountCategoryRequest;
use App\Models\Company;
use App\Models\OrgAccountCategory;
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
    public function index(Request $request, $account)
    {
        $companyID = session('company_id');
        $orgAccountCategories = $this->orgAccountCategoryRepository->where("company_id", $companyID);

        return view('org_account_categories.index', [
            'account' => $account
        ])
            ->with('orgAccountCategories', $orgAccountCategories);
    }

    /**
     * Show the form for creating a new OrgAccountCategory.
     *
     * @return Response
     */
    public function create($account)
    {
        $companies = Company::orderBy('name', 'desc')->pluck('name', 'id');
        return view('org_account_categories.create', [
            'account' => $account,
            'companies' => $companies
        ]);
    }

    /**
     * Store a newly created OrgAccountCategory in storage.
     *
     * @param CreateOrgAccountCategoryRequest $request
     *
     * @param $account
     * @return Response
     */
    public function store(CreateOrgAccountCategoryRequest $request, $account)
    {
        $input = $request->all();
        $count = OrgAccountCategory::whereRaw('company_id=? AND prefix_digit = ?', [$input['company_id'], $input['prefix_digit']])->count();
        if ($count > 0) {
            Flash::error("Account category exists already");
            return redirect()->back()->withInput();
        }

        $orgAccountCategory = $this->orgAccountCategoryRepository->create($input);
        Flash::success('Org Account Category saved successfully.');
        return redirect(route('orgAccountCategories.index', $account));
    }

    /**
     * Display the specified OrgAccountCategory.
     *
     * @param int $id
     *
     * @param $account
     * @return Response
     */
    public function show($id, $account)
    {
        $orgAccountCategory = $this->orgAccountCategoryRepository->find($id);

        if (empty($orgAccountCategory)) {
            Flash::error('Org Account Category not found');

            return redirect(route('orgAccountCategories.index', $account));
        }

        return view('org_account_categories.show', [
            'account' => $account
        ])->with('orgAccountCategory', $orgAccountCategory);
    }

    /**
     * Show the form for editing the specified OrgAccountCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($account, $id)
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
    public function update($account, $id, UpdateOrgAccountCategoryRequest $request)
    {
        $orgAccountCategory = $this->orgAccountCategoryRepository->find($id);

        if (empty($orgAccountCategory)) {
            Flash::error('Org Account Category not found');

            return redirect(route('orgAccountCategories.index', [
                'account' => $account
            ]));
        }

        $orgAccountCategory = $this->orgAccountCategoryRepository->update($request->all(), $id);

        Flash::success('Org Account Category updated successfully.');

        return redirect(route('orgAccountCategories.index', [
            'account' => $account
        ]));
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
    public function destroy($account, $id)
    {
        $orgAccountCategory = $this->orgAccountCategoryRepository->find($id);

        if (empty($orgAccountCategory)) {
            Flash::error('Org Account Category not found');

            return redirect(route('orgAccountCategories.index'));
        }

        $this->orgAccountCategoryRepository->delete($id);

        Flash::success('Org Account Category deleted successfully.');

        return redirect(route('orgAccountCategories.index', $account));
    }
}
