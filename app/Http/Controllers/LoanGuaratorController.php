<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLoanGuaratorRequest;
use App\Http\Requests\UpdateLoanGuaratorRequest;
use App\Repositories\LoanGuaratorRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class LoanGuaratorController extends AppBaseController
{
    /** @var  LoanGuaratorRepository */
    private $loanGuaratorRepository;

    public function __construct(LoanGuaratorRepository $loanGuaratorRepo)
    {
        $this->loanGuaratorRepository = $loanGuaratorRepo;
    }

    /**
     * Display a listing of the LoanGuarator.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request, $account)
    {
        $loanGuarators = $this->loanGuaratorRepository->all();

        return view('loan_guarators.index', ['account' => $account])
            ->with('loanGuarators', $loanGuarators);
    }

    /**
     * Show the form for creating a new LoanGuarator.
     *
     * @return Response
     */
    public function create($account)
    {
        return view('loan_guarators.create', ['account' => $account]);
    }

    /**
     * Store a newly created LoanGuarator in storage.
     *
     * @param CreateLoanGuaratorRequest $request
     *
     * @return Response
     */
    public function store(CreateLoanGuaratorRequest $request, $account)
    {
        $input = $request->all();

        $loanGuarator = $this->loanGuaratorRepository->create($input);

        Flash::success('Loan Guarator saved successfully.');

        return redirect(route('loanGuarators.index', $account));
    }

    /**
     * Display the specified LoanGuarator.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($account, $id)
    {
        $loanGuarator = $this->loanGuaratorRepository->find($id);

        if (empty($loanGuarator)) {
            Flash::error('Loan Guarator not found');

            return redirect(route('loanGuarators.index', $account));
        }

        return view('loan_guarators.show', ['account' => $account])->with('loanGuarator', $loanGuarator);
    }

    /**
     * Show the form for editing the specified LoanGuarator.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $loanGuarator = $this->loanGuaratorRepository->find($id);

        if (empty($loanGuarator)) {
            Flash::error('Loan Guarator not found');

            return redirect(route('loanGuarators.index'));
        }

        return view('loan_guarators.edit')->with('loanGuarator', $loanGuarator);
    }

    /**
     * Update the specified LoanGuarator in storage.
     *
     * @param int $id
     * @param UpdateLoanGuaratorRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLoanGuaratorRequest $request)
    {
        $loanGuarator = $this->loanGuaratorRepository->find($id);

        if (empty($loanGuarator)) {
            Flash::error('Loan Guarator not found');

            return redirect(route('loanGuarators.index'));
        }

        $loanGuarator = $this->loanGuaratorRepository->update($request->all(), $id);

        Flash::success('Loan Guarator updated successfully.');

        return redirect(route('loanGuarators.index'));
    }

    /**
     * Remove the specified LoanGuarator from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $loanGuarator = $this->loanGuaratorRepository->find($id);

        if (empty($loanGuarator)) {
            Flash::error('Loan Guarator not found');

            return redirect(route('loanGuarators.index'));
        }

        $this->loanGuaratorRepository->delete($id);

        Flash::success('Loan Guarator deleted successfully.');

        return redirect(route('loanGuarators.index'));
    }
}
