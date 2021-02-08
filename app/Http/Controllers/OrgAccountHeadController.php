<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrgAccountHeadRequest;
use App\Http\Requests\UpdateOrgAccountHeadRequest;
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
    public function index(Request $request)
    {
        $orgAccountHeads = $this->orgAccountHeadRepository->all();

        return view('org_account_heads.index')
            ->with('orgAccountHeads', $orgAccountHeads);
    }

    /**
     * Show the form for creating a new OrgAccountHead.
     *
     * @return Response
     */
    public function create()
    {
        return view('org_account_heads.create');
    }

    /**
     * Store a newly created OrgAccountHead in storage.
     *
     * @param CreateOrgAccountHeadRequest $request
     *
     * @return Response
     */
    public function store(CreateOrgAccountHeadRequest $request)
    {
        $input = $request->all();

        $orgAccountHead = $this->orgAccountHeadRepository->create($input);

        Flash::success('Org Account Head saved successfully.');

        return redirect(route('orgAccountHeads.index'));
    }

    /**
     * Display the specified OrgAccountHead.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
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
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $orgAccountHead = $this->orgAccountHeadRepository->find($id);

        if (empty($orgAccountHead)) {
            Flash::error('Org Account Head not found');

            return redirect(route('orgAccountHeads.index'));
        }

        return view('org_account_heads.edit')->with('orgAccountHead', $orgAccountHead);
    }

    /**
     * Update the specified OrgAccountHead in storage.
     *
     * @param int $id
     * @param UpdateOrgAccountHeadRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOrgAccountHeadRequest $request)
    {
        $orgAccountHead = $this->orgAccountHeadRepository->find($id);

        if (empty($orgAccountHead)) {
            Flash::error('Org Account Head not found');

            return redirect(route('orgAccountHeads.index'));
        }

        $orgAccountHead = $this->orgAccountHeadRepository->update($request->all(), $id);

        Flash::success('Org Account Head updated successfully.');

        return redirect(route('orgAccountHeads.index'));
    }

    /**
     * Remove the specified OrgAccountHead from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $orgAccountHead = $this->orgAccountHeadRepository->find($id);

        if (empty($orgAccountHead)) {
            Flash::error('Org Account Head not found');

            return redirect(route('orgAccountHeads.index'));
        }

        $this->orgAccountHeadRepository->delete($id);

        Flash::success('Org Account Head deleted successfully.');

        return redirect(route('orgAccountHeads.index'));
    }
}
