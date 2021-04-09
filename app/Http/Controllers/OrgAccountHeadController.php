<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrgAccountHeadRequest;
use App\Http\Requests\UpdateOrgAccountHeadRequest;
use App\Models\Company;
use App\Models\OrgAccountCategory;
use App\Models\OrgAccountHead;
use App\Repositories\OrgAccountHeadRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class OrgAccountHeadController extends AppBaseController
{
    /** @var  OrgAccountHeadRepository */
    private $orgAccountHeadRepository;

    public function __construct(OrgAccountHeadRepository $orgAccountHeadRepo)
    {
        $this->orgAccountHeadRepository = $orgAccountHeadRepo;
    }

    /**
     * Display a listing of the OrgAccountHead.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request, $account)
    {
        $companyID = session('company_id');
        $orgAccountHeads = $this->orgAccountHeadRepository->where("company_id", $companyID);

        return view('org_account_heads.index', [
            'account' => $account
        ])
            ->with('orgAccountHeads', $orgAccountHeads);
    }

    /**
     * Show the form for creating a new OrgAccountHead.
     *
     * @return Response
     */
    public function create($account)
    {
        //TODO: return the categories based on the company name
        $companies = Company::orderBy('name', 'desc')->pluck('name', 'id');
        $categories = OrgAccountCategory::orderBy('name', 'asc')->pluck('name', 'id');
        return view('org_account_heads.create', [
            'companies' => $companies,
            'categories' => $categories,
            'account' => $account
        ]);
    }

    /**
     * Store a newly created OrgAccountHead in storage.
     *
     * @param CreateOrgAccountHeadRequest $request
     *
     * @return Response
     */
    public function store(CreateOrgAccountHeadRequest $request, $account)
    {
        $input = $request->all();
        $category = OrgAccountCategory::WhereRaw('company_id=? AND id=?', [$input['company_id'], $input['category_id']])->get();
        $input['code'] = $category->first()->prefix_digit . $input['code'];

        if (OrgAccountHead::whereRaw('company_id=? and code=?', [$input['company_id'], $input['code']])->count() > 0) {
            Flash::error("Code already exists");
            return redirect()->back()->withInput();
        }

        $orgAccountHead = $this->orgAccountHeadRepository->create($input);

        Flash::success('Org Account Head saved successfully.');

        return redirect(route('orgAccountHeads.index',$account));
    }

    /**
     * Display the specified OrgAccountHead.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($account, $id)
    {
        $orgAccountHead = $this->orgAccountHeadRepository->find($id);

        if (empty($orgAccountHead)) {
            Flash::error('Org Account Head not found');

            return redirect(route('orgAccountHeads.index'));
        }

        return view('org_account_heads.show')->with('orgAccountHead', $orgAccountHead);
    }

    /**
     * Show the form for editing the specified OrgAccountHead.
     *
     * @param $account
     * @param int $id
     *
     * @return Response
     */
    public function edit($account, $id)
    {
        $orgAccountHead = $this->orgAccountHeadRepository->find($id);
        $companies = Company::orderBy('name', 'desc')->pluck('name', 'id');
        $categories = OrgAccountCategory::orderBy('name', 'asc')->pluck('name', 'id');

        if (empty($orgAccountHead)) {
            Flash::error('Org Account Head not found');

            return redirect(route('orgAccountHeads.index'));
        }

        return view('org_account_heads.edit', [
            'companies' => $companies,
            'categories' => $categories,
            'account'=>$account
        ])->with('orgAccountHead', $orgAccountHead);
    }

    /**
     * Update the specified OrgAccountHead in storage.
     *
     * @param int $id
     * @param UpdateOrgAccountHeadRequest $request
     *
     * @return Response
     */
    public function update($account, $id, UpdateOrgAccountHeadRequest $request)
    {
        $orgAccountHead = $this->orgAccountHeadRepository->find($id);

        if (empty($orgAccountHead)) {
            Flash::error('Org Account Head not found');

            return redirect(route('orgAccountHeads.index'));
        }

        $orgAccountHead = $this->orgAccountHeadRepository->update($request->all(), $id);

        Flash::success('Org Account Head updated successfully.');

        return redirect(route('orgAccountHeads.index',$account));
    }

    /**
     * Remove the specified OrgAccountHead from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($account, $id)
    {
        $orgAccountHead = $this->orgAccountHeadRepository->find($id);

        if (empty($orgAccountHead)) {
            Flash::error('Org Account Head not found');

            return redirect(route('orgAccountHeads.index'));
        }

        $this->orgAccountHeadRepository->delete($id);

        Flash::success('Org Account Head deleted successfully.');

        return redirect(route('orgAccountHeads.index',$account));
    }
}
