<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerLoanRequest;
use App\Http\Requests\UpdateCustomerLoanRequest;
use App\Repositories\CustomerLoanRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class CustomerLoanController extends AppBaseController
{
    /** @var  CustomerLoanRepository */
    private $customerLoanRepository;

    public function __construct(CustomerLoanRepository $customerLoanRepo)
    {
        $this->customerLoanRepository = $customerLoanRepo;
    }

    /**
     * Display a listing of the CustomerLoan.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $customerLoans = $this->customerLoanRepository->all();

        return view('customer_loans.index')
            ->with('customerLoans', $customerLoans);
    }

    /**
     * Show the form for creating a new CustomerLoan.
     *
     * @return Response
     */
    public function create()
    {
        return view('customer_loans.create');
    }

    /**
     * Store a newly created CustomerLoan in storage.
     *
     * @param CreateCustomerLoanRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerLoanRequest $request)
    {
        $input = $request->all();

        $customerLoan = $this->customerLoanRepository->create($input);

        Flash::success('Customer Loan saved successfully.');

        return redirect(route('customerLoans.index'));
    }

    /**
     * Display the specified CustomerLoan.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customerLoan = $this->customerLoanRepository->find($id);

        if (empty($customerLoan)) {
            Flash::error('Customer Loan not found');

            return redirect(route('customerLoans.index'));
        }

        return view('customer_loans.show')->with('customerLoan', $customerLoan);
    }

    /**
     * Show the form for editing the specified CustomerLoan.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customerLoan = $this->customerLoanRepository->find($id);

        if (empty($customerLoan)) {
            Flash::error('Customer Loan not found');

            return redirect(route('customerLoans.index'));
        }

        return view('customer_loans.edit')->with('customerLoan', $customerLoan);
    }

    /**
     * Update the specified CustomerLoan in storage.
     *
     * @param int $id
     * @param UpdateCustomerLoanRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerLoanRequest $request)
    {
        $customerLoan = $this->customerLoanRepository->find($id);

        if (empty($customerLoan)) {
            Flash::error('Customer Loan not found');

            return redirect(route('customerLoans.index'));
        }

        $customerLoan = $this->customerLoanRepository->update($request->all(), $id);

        Flash::success('Customer Loan updated successfully.');

        return redirect(route('customerLoans.index'));
    }

    /**
     * Remove the specified CustomerLoan from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $customerLoan = $this->customerLoanRepository->find($id);

        if (empty($customerLoan)) {
            Flash::error('Customer Loan not found');

            return redirect(route('customerLoans.index'));
        }

        $this->customerLoanRepository->delete($id);

        Flash::success('Customer Loan deleted successfully.');

        return redirect(route('customerLoans.index'));
    }
}
