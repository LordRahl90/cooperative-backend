<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLoanRepaymentRequest;
use App\Http\Requests\UpdateLoanRepaymentRequest;
use App\Repositories\LoanRepaymentRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class LoanRepaymentController extends AppBaseController
{
    /** @var  LoanRepaymentRepository */
    private $loanRepaymentRepository;

    public function __construct(LoanRepaymentRepository $loanRepaymentRepo)
    {
        $this->loanRepaymentRepository = $loanRepaymentRepo;
    }

    /**
     * Display a listing of the LoanRepayment.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $loanRepayments = $this->loanRepaymentRepository->all();

        return view('loan_repayments.index')
            ->with('loanRepayments', $loanRepayments);
    }

    /**
     * Show the form for creating a new LoanRepayment.
     *
     * @return Response
     */
    public function create()
    {
        return view('loan_repayments.create');
    }

    /**
     * Store a newly created LoanRepayment in storage.
     *
     * @param CreateLoanRepaymentRequest $request
     *
     * @return Response
     */
    public function store(CreateLoanRepaymentRequest $request)
    {
        $input = $request->all();

        $loanRepayment = $this->loanRepaymentRepository->create($input);

        Flash::success('Loan Repayment saved successfully.');

        return redirect(route('loanRepayments.index'));
    }

    /**
     * Display the specified LoanRepayment.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $loanRepayment = $this->loanRepaymentRepository->find($id);

        if (empty($loanRepayment)) {
            Flash::error('Loan Repayment not found');

            return redirect(route('loanRepayments.index'));
        }

        return view('loan_repayments.show')->with('loanRepayment', $loanRepayment);
    }

    /**
     * Show the form for editing the specified LoanRepayment.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $loanRepayment = $this->loanRepaymentRepository->find($id);

        if (empty($loanRepayment)) {
            Flash::error('Loan Repayment not found');

            return redirect(route('loanRepayments.index'));
        }

        return view('loan_repayments.edit')->with('loanRepayment', $loanRepayment);
    }

    /**
     * Update the specified LoanRepayment in storage.
     *
     * @param int $id
     * @param UpdateLoanRepaymentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLoanRepaymentRequest $request)
    {
        $loanRepayment = $this->loanRepaymentRepository->find($id);

        if (empty($loanRepayment)) {
            Flash::error('Loan Repayment not found');

            return redirect(route('loanRepayments.index'));
        }

        $loanRepayment = $this->loanRepaymentRepository->update($request->all(), $id);

        Flash::success('Loan Repayment updated successfully.');

        return redirect(route('loanRepayments.index'));
    }

    /**
     * Remove the specified LoanRepayment from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $loanRepayment = $this->loanRepaymentRepository->find($id);

        if (empty($loanRepayment)) {
            Flash::error('Loan Repayment not found');

            return redirect(route('loanRepayments.index'));
        }

        $this->loanRepaymentRepository->delete($id);

        Flash::success('Loan Repayment deleted successfully.');

        return redirect(route('loanRepayments.index'));
    }
}
