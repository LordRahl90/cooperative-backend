<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSavingsCategoryRequest;
use App\Http\Requests\UpdateSavingsCategoryRequest;
use App\Models\Company;
use App\Models\OrgAccountCategory;
use App\Repositories\SavingsCategoryRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class SavingsCategoryController extends AppBaseController
{
    /** @var  SavingsCategoryRepository */
    private $savingsCategoryRepository;

    public function __construct(SavingsCategoryRepository $savingsCategoryRepo)
    {
        $this->savingsCategoryRepository = $savingsCategoryRepo;
    }

    /**
     * Display a listing of the SavingsCategory.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $savingsCategories = $this->savingsCategoryRepository->all();

        return view('savings_categories.index')
            ->with('savingsCategories', $savingsCategories);
    }

    /**
     * Show the form for creating a new SavingsCategory.
     *
     * @return Response
     */
    public function create()
    {
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $categories = OrgAccountCategory::where('company_id', session('company_id'))->pluck('name', 'id');
        return view('savings_categories.create', [
            'companies' => $companies,
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created SavingsCategory in storage.
     *
     * @param CreateSavingsCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateSavingsCategoryRequest $request)
    {
        $input = $request->all();

        $savingsCategory = $this->savingsCategoryRepository->create($input);

        Flash::success('Savings Category saved successfully.');

        return redirect(route('savingsCategories.index'));
    }

    /**
     * Display the specified SavingsCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $savingsCategory = $this->savingsCategoryRepository->find($id);

        if (empty($savingsCategory)) {
            Flash::error('Savings Category not found');

            return redirect(route('savingsCategories.index'));
        }

        return view('savings_categories.show')->with('savingsCategory', $savingsCategory);
    }

    /**
     * Show the form for editing the specified SavingsCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $categories = OrgAccountCategory::where('company_id', session('company_id'))->pluck('name', 'id');
        $savingsCategory = $this->savingsCategoryRepository->find($id);

        if (empty($savingsCategory)) {
            Flash::error('Savings Category not found');

            return redirect(route('savingsCategories.index'));
        }

        return view('savings_categories.edit', [
            'companies' => $companies,
            'categories' => $categories
        ])->with('savingsCategory', $savingsCategory);
    }

    /**
     * Update the specified SavingsCategory in storage.
     *
     * @param int $id
     * @param UpdateSavingsCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSavingsCategoryRequest $request)
    {
        $savingsCategory = $this->savingsCategoryRepository->find($id);

        if (empty($savingsCategory)) {
            Flash::error('Savings Category not found');

            return redirect(route('savingsCategories.index'));
        }

        $savingsCategory = $this->savingsCategoryRepository->update($request->all(), $id);

        Flash::success('Savings Category updated successfully.');

        return redirect(route('savingsCategories.index'));
    }

    /**
     * Remove the specified SavingsCategory from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $savingsCategory = $this->savingsCategoryRepository->find($id);

        if (empty($savingsCategory)) {
            Flash::error('Savings Category not found');

            return redirect(route('savingsCategories.index'));
        }

        $this->savingsCategoryRepository->delete($id);

        Flash::success('Savings Category deleted successfully.');

        return redirect(route('savingsCategories.index'));
    }
}
