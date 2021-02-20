<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLoanCategoryRequest;
use App\Http\Requests\UpdateLoanCategoryRequest;
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
    public function index(Request $request)
    {
        $loanCategories = $this->loanCategoryRepository->all();

        return view('loan_categories.index')
            ->with('loanCategories', $loanCategories);
    }

    /**
     * Show the form for creating a new LoanCategory.
     *
     * @return Response
     */
    public function create()
    {
        return view('loan_categories.create');
    }

    /**
     * Store a newly created LoanCategory in storage.
     *
     * @param CreateLoanCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateLoanCategoryRequest $request)
    {
        $input = $request->all();

        $loanCategory = $this->loanCategoryRepository->create($input);

        Flash::success('Loan Category saved successfully.');

        return redirect(route('loanCategories.index'));
    }

    /**
     * Display the specified LoanCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $loanCategory = $this->loanCategoryRepository->find($id);

        if (empty($loanCategory)) {
            Flash::error('Loan Category not found');

            return redirect(route('loanCategories.index'));
        }

        return view('loan_categories.show')->with('loanCategory', $loanCategory);
    }

    /**
     * Show the form for editing the specified LoanCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $loanCategory = $this->loanCategoryRepository->find($id);

        if (empty($loanCategory)) {
            Flash::error('Loan Category not found');

            return redirect(route('loanCategories.index'));
        }

        return view('loan_categories.edit')->with('loanCategory', $loanCategory);
    }

    /**
     * Update the specified LoanCategory in storage.
     *
     * @param int $id
     * @param UpdateLoanCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLoanCategoryRequest $request)
    {
        $loanCategory = $this->loanCategoryRepository->find($id);

        if (empty($loanCategory)) {
            Flash::error('Loan Category not found');

            return redirect(route('loanCategories.index'));
        }

        $loanCategory = $this->loanCategoryRepository->update($request->all(), $id);

        Flash::success('Loan Category updated successfully.');

        return redirect(route('loanCategories.index'));
    }

    /**
     * Remove the specified LoanCategory from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $loanCategory = $this->loanCategoryRepository->find($id);

        if (empty($loanCategory)) {
            Flash::error('Loan Category not found');

            return redirect(route('loanCategories.index'));
        }

        $this->loanCategoryRepository->delete($id);

        Flash::success('Loan Category deleted successfully.');

        return redirect(route('loanCategories.index'));
    }
}
