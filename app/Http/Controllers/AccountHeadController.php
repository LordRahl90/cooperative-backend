<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAccountHeadRequest;
use App\Http\Requests\UpdateAccountHeadRequest;
use App\Models\AccountCategory;
use App\Models\AccountHead;
use App\Repositories\AccountHeadRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class AccountHeadController extends AppBaseController
{
    /** @var  AccountHeadRepository */
    private $accountHeadRepository;

    public function __construct(AccountHeadRepository $accountHeadRepo)
    {
        $this->accountHeadRepository = $accountHeadRepo;
    }

    /**
     * Display a listing of the AccountHead.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $accountHeads = $this->accountHeadRepository->all();

        return view('account_heads.index')
            ->with('accountHeads', $accountHeads);
    }

    /**
     * Show the form for creating a new AccountHead.
     *
     * @return Response
     */
    public function create()
    {
        $categories = AccountCategory::orderBy('name', 'asc')->pluck('name', 'id');
        return view('account_heads.create', [
            'categories' => $categories->toArray()
        ]);
    }

    /**
     * Store a newly created AccountHead in storage.
     *
     * @param CreateAccountHeadRequest $request
     *
     * @return Response
     */
    public function store(CreateAccountHeadRequest $request)
    {
        $input = $request->all();
        $category = AccountCategory::find($input['category_id']);
        $input['code'] = $category->prefix_digit . $input['code'];

        if (AccountHead::where('code', $input['code'])->count() > 0) {
            Flash::error("Account code already exists");
            return redirect()->back()->withInput();
        }

        $accountHead = $this->accountHeadRepository->create($input);

        Flash::success('Account Head saved successfully.');

        return redirect(route('accountHeads.index'));
    }

    /**
     * Display the specified AccountHead.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $accountHead = $this->accountHeadRepository->find($id);

        if (empty($accountHead)) {
            Flash::error('Account Head not found');

            return redirect(route('accountHeads.index'));
        }

        return view('account_heads.show')->with('accountHead', $accountHead);
    }

    /**
     * Show the form for editing the specified AccountHead.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $accountHead = $this->accountHeadRepository->find($id);

        if (empty($accountHead)) {
            Flash::error('Account Head not found');

            return redirect(route('accountHeads.index'));
        }

        return view('account_heads.edit')->with('accountHead', $accountHead);
    }

    /**
     * Update the specified AccountHead in storage.
     *
     * @param int $id
     * @param UpdateAccountHeadRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAccountHeadRequest $request)
    {
        $accountHead = $this->accountHeadRepository->find($id);

        if (empty($accountHead)) {
            Flash::error('Account Head not found');

            return redirect(route('accountHeads.index'));
        }

        $accountHead = $this->accountHeadRepository->update($request->all(), $id);

        Flash::success('Account Head updated successfully.');

        return redirect(route('accountHeads.index'));
    }

    /**
     * Remove the specified AccountHead from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $accountHead = $this->accountHeadRepository->find($id);

        if (empty($accountHead)) {
            Flash::error('Account Head not found');

            return redirect(route('accountHeads.index'));
        }

        $this->accountHeadRepository->delete($id);

        Flash::success('Account Head deleted successfully.');

        return redirect(route('accountHeads.index'));
    }
}
