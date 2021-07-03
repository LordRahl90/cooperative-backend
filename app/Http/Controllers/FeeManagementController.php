<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFeeManagementRequest;
use App\Http\Requests\UpdateFeeManagementRequest;
use App\Repositories\FeeManagementRepository;
use App\Http\Controllers\AppBaseController;
use App\Utility\Utility;
use Illuminate\Http\Request;
use Flash;
use Response;

class FeeManagementController extends AppBaseController
{
    /** @var  FeeManagementRepository */
    private $feeManagementRepository;

    public function __construct(FeeManagementRepository $feeManagementRepo)
    {
        $this->feeManagementRepository = $feeManagementRepo;
    }

    /**
     * Display a listing of the FeeManagement.
     *
     * @param Request $request
     *
     * @param $account
     * @return Response
     */
    public function index(Request $request, $account)
    {
        $companyID = session('company_id');
        $feeManagements = $this->feeManagementRepository->where('company_id', $companyID);

        return view('fee_managements.index', [
            'account' => $account
        ])->with('feeManagements', $feeManagements);
    }

    /**
     * Show the form for creating a new FeeManagement.
     *
     * @param $account
     * @return Response
     */
    public function create($account)
    {
        $companyID = session('company_id');
        $accountHeads = Utility::getAccountHeads($companyID);
        return view('fee_managements.create', [
            'account' => $account,
            'accountHeads' => $accountHeads
        ]);
    }

    /**
     * Store a newly created FeeManagement in storage.
     *
     * @param CreateFeeManagementRequest $request
     *
     * @param $account
     * @return Response
     */
    public function store(CreateFeeManagementRequest $request, $account)
    {
        $input = $request->all();
        $input['company_id'] = session('company_id');
        $input['duration'] = 0;

        $feeManagement = $this->feeManagementRepository->create($input);

        Flash::success('Fee Management saved successfully.');

        return redirect(route('feeManagements.index', $account));
    }

    /**
     * Display the specified FeeManagement.
     *
     * @param int $id
     *
     * @param $account
     * @return Response
     */
    public function show($id, $account)
    {
        $feeManagement = $this->feeManagementRepository->find($id);

        if (empty($feeManagement)) {
            Flash::error('Fee Management not found');

            return redirect(route('feeManagements.index', $account));
        }

        return view('fee_managements.show', [
            'account' => $account
        ])->with('feeManagement', $feeManagement);
    }

    /**
     * Show the form for editing the specified FeeManagement.
     *
     * @param int $id
     *
     * @param $account
     * @return Response
     */
    public function edit($id, $account)
    {
        $feeManagement = $this->feeManagementRepository->find($id);

        if (empty($feeManagement)) {
            Flash::error('Fee Management not found');

            return redirect(route('feeManagements.index', $account));
        }

        return view('fee_managements.edit', [
            'account' => $account
        ])->with('feeManagement', $feeManagement);
    }

    /**
     * Update the specified FeeManagement in storage.
     *
     * @param $account
     * @param int $id
     * @param UpdateFeeManagementRequest $request
     *
     * @return Response
     */
    public function update($account, $id, UpdateFeeManagementRequest $request)
    {
        $feeManagement = $this->feeManagementRepository->find($id);

        if (empty($feeManagement)) {
            Flash::error('Fee Management not found');

            return redirect(route('feeManagements.index', $account));
        }

        $feeManagement = $this->feeManagementRepository->update($request->all(), $id);

        Flash::success('Fee Management updated successfully.');

        return redirect(route('feeManagements.index', [
            'account' => $account
        ]));
    }

    /**
     * Remove the specified FeeManagement from storage.
     *
     * @param int $id
     *
     * @param $account
     * @return Response
     * @throws \Exception
     */
    public function destroy($id, $account)
    {
        $feeManagement = $this->feeManagementRepository->find($id);

        if (empty($feeManagement)) {
            Flash::error('Fee Management not found');

            return redirect(route('feeManagements.index', $account));
        }

        $this->feeManagementRepository->delete($id);

        Flash::success('Fee Management deleted successfully.');

        return redirect(route('feeManagements.index', $account));
    }
}
