<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAccountCategoryRequest;
use App\Http\Requests\UpdateAccountCategoryRequest;
use App\Repositories\AccountCategoryRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class AccountCategoryController extends AppBaseController
{
    /** @var  AccountCategoryRepository */
    private $accountCategoryRepository;

    public function __construct(AccountCategoryRepository $accountCategoryRepo)
    {
        $this->accountCategoryRepository = $accountCategoryRepo;
    }

    /**
     * Display a listing of the AccountCategory.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $accountCategories = $this->accountCategoryRepository->all();

        return view('account_categories.index')
            ->with('accountCategories', $accountCategories);
    }

    /**
     * Show the form for creating a new AccountCategory.
     *
     * @return Response
     */
    public function create()
    {
        return view('account_categories.create');
    }

    /**
     * Store a newly created AccountCategory in storage.
     *
     * @param CreateAccountCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateAccountCategoryRequest $request)
    {
        $input = $request->all();

        $accountCategory = $this->accountCategoryRepository->create($input);

        Flash::success('Account Category saved successfully.');

        return redirect(route('accountCategories.index'));
    }

    /**
     * Display the specified AccountCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $accountCategory = $this->accountCategoryRepository->find($id);

        if (empty($accountCategory)) {
            Flash::error('Account Category not found');

            return redirect(route('accountCategories.index'));
        }

        return view('account_categories.show')->with('accountCategory', $accountCategory);
    }

    /**
     * Show the form for editing the specified AccountCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $accountCategory = $this->accountCategoryRepository->find($id);

        if (empty($accountCategory)) {
            Flash::error('Account Category not found');

            return redirect(route('accountCategories.index'));
        }

        return view('account_categories.edit')->with('accountCategory', $accountCategory);
    }

    /**
     * Update the specified AccountCategory in storage.
     *
     * @param int $id
     * @param UpdateAccountCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAccountCategoryRequest $request)
    {
        $accountCategory = $this->accountCategoryRepository->find($id);

        if (empty($accountCategory)) {
            Flash::error('Account Category not found');

            return redirect(route('accountCategories.index'));
        }

        $accountCategory = $this->accountCategoryRepository->update($request->all(), $id);

        Flash::success('Account Category updated successfully.');

        return redirect(route('accountCategories.index'));
    }

    /**
     * Remove the specified AccountCategory from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $accountCategory = $this->accountCategoryRepository->find($id);

        if (empty($accountCategory)) {
            Flash::error('Account Category not found');

            return redirect(route('accountCategories.index'));
        }

        $this->accountCategoryRepository->delete($id);

        Flash::success('Account Category deleted successfully.');

        return redirect(route('accountCategories.index'));
    }
}
