<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLoanCategoryRequest;
use App\Http\Requests\UpdateLoanCategoryRequest;
use App\Models\Company;
use App\Models\OrgAccountCategory;
use App\Repositories\LoanCategoryRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class LoanCategoryController extends AppBaseController
{
    /** @var  LoanCategoryRepository */
    private $loanCategoryRepository;

    public function __construct(LoanCategoryRepository $loanCategoryRepo)
    {
        $this->loanCategoryRepository = $loanCategoryRepo;
    }

    /**
     * Display a listing of the LoanCategory.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request, $account)
    {
        $companyID = session('company_id');
        $loanCategories = $this->loanCategoryRepository->where('company_id', $companyID);

        return view('loan_categories.index', ['account' => $account])
            ->with('loanCategories', $loanCategories);
    }

    /**
     * Show the form for creating a new LoanCategory.
     *
     * @return Response
     */
    public function create($account)
    {
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $categories = OrgAccountCategory::where('company_id', session('company_id'))->pluck('name', 'id');
        return view('loan_categories.create', [
            'companies' => $companies,
            'categories' => $categories,
            'account' => $account
        ]);
    }

    /**
     * Store a newly created LoanCategory in storage.
     *
     * @param CreateLoanCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateLoanCategoryRequest $request, $account)
    {
        $input = $request->all();

        $loanCategory = $this->loanCategoryRepository->create($input);

        Flash::success('Loan Category saved successfully.');

        return redirect(route('loanCategories.index', $account));
    }

    /**
     * Display the specified LoanCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($account, $id)
    {
        $loanCategory = $this->loanCategoryRepository->find($id);

        if (empty($loanCategory)) {
            Flash::error('Loan Category not found');

            return redirect(route('loanCategories.index', $account));
        }

        return view('loan_categories.show', ['account' => $account])->with('loanCategory', $loanCategory);
    }

    /**
     * Show the form for editing the specified LoanCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($account, $id)
    {
        $loanCategory = $this->loanCategoryRepository->find($id);

        if (empty($loanCategory)) {
            Flash::error('Loan Category not found');

            return redirect(route('loanCategories.index', $account));
        }
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $categories = OrgAccountCategory::where('company_id', session('company_id'))->pluck('name', 'id');

        return view('loan_categories.edit', [
            'companies' => $companies,
            'categories' => $categories,
            'account' => $account
        ])->with('loanCategory', $loanCategory);
    }

    /**
     * Update the specified LoanCategory in storage.
     *
     * @param $account
     * @param int $id
     * @param UpdateLoanCategoryRequest $request
     *
     * @return Response
     */
    public function update($account, $id, UpdateLoanCategoryRequest $request)
    {
        $loanCategory = $this->loanCategoryRepository->find($id);

        if (empty($loanCategory)) {
            Flash::error('Loan Category not found');

            return redirect(route('loanCategories.index'));
        }

        $loanCategory = $this->loanCategoryRepository->update($request->all(), $id);

        Flash::success('Loan Category updated successfully.');

        return redirect(route('loanCategories.index', $account));
    }

    /**
     * Remove the specified LoanCategory from storage.
     *
     * @param $account
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     */
    public function destroy($account, $id)
    {
        $loanCategory = $this->loanCategoryRepository->find($id);

        if (empty($loanCategory)) {
            Flash::error('Loan Category not found');

            return redirect(route('loanCategories.index', $account));
        }

        $this->loanCategoryRepository->delete($id);

        Flash::success('Loan Category deleted successfully.');

        return redirect(route('loanCategories.index', $account));
    }
}
