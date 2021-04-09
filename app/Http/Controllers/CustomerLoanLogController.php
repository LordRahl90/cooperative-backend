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
     * @return Response
     */
    public function index(Request $request)
    {
        $customerLoanLogs = $this->customerLoanLogRepository->all();

        return view('customer_loan_logs.index')
            ->with('customerLoanLogs', $customerLoanLogs);
    }

    /**
     * Show the form for creating a new CustomerLoanLog.
     *
     * @return Response
     */
    public function create()
    {
        return view('customer_loan_logs.create');
    }

    /**
     * Store a newly created CustomerLoanLog in storage.
     *
     * @param CreateCustomerLoanLogRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerLoanLogRequest $request)
    {
        $input = $request->all();

        $customerLoanLog = $this->customerLoanLogRepository->create($input);

        Flash::success('Customer Loan Log saved successfully.');

        return redirect(route('customerLoanLogs.index'));
    }

    /**
     * Display the specified CustomerLoanLog.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customerLoanLog = $this->customerLoanLogRepository->find($id);

        if (empty($customerLoanLog)) {
            Flash::error('Customer Loan Log not found');

            return redirect(route('customerLoanLogs.index'));
        }

        return view('customer_loan_logs.show')->with('customerLoanLog', $customerLoanLog);
    }

    /**
     * Show the form for editing the specified CustomerLoanLog.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customerLoanLog = $this->customerLoanLogRepository->find($id);

        if (empty($customerLoanLog)) {
            Flash::error('Customer Loan Log not found');

            return redirect(route('customerLoanLogs.index'));
        }

        return view('customer_loan_logs.edit')->with('customerLoanLog', $customerLoanLog);
    }

    /**
     * Update the specified CustomerLoanLog in storage.
     *
     * @param int $id
     * @param UpdateCustomerLoanLogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerLoanLogRequest $request)
    {
        $customerLoanLog = $this->customerLoanLogRepository->find($id);

        if (empty($customerLoanLog)) {
            Flash::error('Customer Loan Log not found');

            return redirect(route('customerLoanLogs.index'));
        }

        $customerLoanLog = $this->customerLoanLogRepository->update($request->all(), $id);

        Flash::success('Customer Loan Log updated successfully.');

        return redirect(route('customerLoanLogs.index'));
    }

    /**
     * Remove the specified CustomerLoanLog from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $customerLoanLog = $this->customerLoanLogRepository->find($id);

        if (empty($customerLoanLog)) {
            Flash::error('Customer Loan Log not found');

            return redirect(route('customerLoanLogs.index'));
        }

        $this->customerLoanLogRepository->delete($id);

        Flash::success('Customer Loan Log deleted successfully.');

        return redirect(route('customerLoanLogs.index'));
    }
}
