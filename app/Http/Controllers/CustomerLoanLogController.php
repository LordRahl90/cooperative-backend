<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerLoanLogRequest;
use App\Http\Requests\UpdateCustomerLoanLogRequest;
use App\Repositories\CustomerLoanLogRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class CustomerLoanLogController extends AppBaseController
{
    /** @var  CustomerLoanLogRepository */
    private $customerLoanLogRepository;

    public function __construct(CustomerLoanLogRepository $customerLoanLogRepo)
    {
        $this->customerLoanLogRepository = $customerLoanLogRepo;
    }

    /**
     * Display a listing of the CustomerLoanLog.
     *
     * @param Request $request
     *
     * @param $account
     * @return Response
     */
    public function index(Request $request, $account)
    {
        $customerLoanLogs = $this->customerLoanLogRepository->all();

        return view('customer_loan_logs.index', [
            'account' => $account
        ])
            ->with('customerLoanLogs', $customerLoanLogs);
    }

    /**
     * Show the form for creating a new CustomerLoanLog.
     *
     * @param $account
     * @return Response
     */
    public function create($account)
    {
        return view('customer_loan_logs.create', [
            'account' => $account
        ]);
    }

    /**
     * Store a newly created CustomerLoanLog in storage.
     *
     * @param CreateCustomerLoanLogRequest $request
     *
     * @param $account
     * @return Response
     */
    public function store(CreateCustomerLoanLogRequest $request, $account)
    {
        $input = $request->all();

        $customerLoanLog = $this->customerLoanLogRepository->create($input);

        Flash::success('Customer Loan Log saved successfully.');

        return redirect(route('customerLoanLogs.index', $account));
    }

    /**
     * Display the specified CustomerLoanLog.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($account, $id)
    {
        $customerLoanLog = $this->customerLoanLogRepository->find($id);

        if (empty($customerLoanLog)) {
            Flash::error('Customer Loan Log not found');

            return redirect(route('customerLoanLogs.index'));
        }

        return view('customer_loan_logs.show', ['account' => $account])->with('customerLoanLog', $customerLoanLog);
    }

    /**
     * Show the form for editing the specified CustomerLoanLog.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($account, $id)
    {
        $customerLoanLog = $this->customerLoanLogRepository->find($id);

        if (empty($customerLoanLog)) {
            Flash::error('Customer Loan Log not found');

            return redirect(route('customerLoanLogs.index'));
        }

        return view('customer_loan_logs.edit', ['account' => $account])->with('customerLoanLog', $customerLoanLog);
    }

    /**
     * Update the specified CustomerLoanLog in storage.
     *
     * @param int $id
     * @param UpdateCustomerLoanLogRequest $request
     *
     * @return Response
     */
    public function update($account, $id, UpdateCustomerLoanLogRequest $request)
    {
        $customerLoanLog = $this->customerLoanLogRepository->find($id);

        if (empty($customerLoanLog)) {
            Flash::error('Customer Loan Log not found');

            return redirect(route('customerLoanLogs.index'));
        }

        $customerLoanLog = $this->customerLoanLogRepository->update($request->all(), $id);

        Flash::success('Customer Loan Log updated successfully.');

        return redirect(route('customerLoanLogs.index', $account));
    }

    /**
     * Remove the specified CustomerLoanLog from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($account, $id)
    {
        $customerLoanLog = $this->customerLoanLogRepository->find($id);

        if (empty($customerLoanLog)) {
            Flash::error('Customer Loan Log not found');

            return redirect(route('customerLoanLogs.index', $account));
        }

        $this->customerLoanLogRepository->delete($id);

        Flash::success('Customer Loan Log deleted successfully.');

        return redirect(route('customerLoanLogs.index', $account));
    }
}
