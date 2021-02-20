<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerTransactionRequest;
use App\Http\Requests\UpdateCustomerTransactionRequest;
use App\Repositories\CustomerTransactionRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class CustomerTransactionController extends AppBaseController
{
    /** @var  CustomerTransactionRepository */
    private $customerTransactionRepository;

    public function __construct(CustomerTransactionRepository $customerTransactionRepo)
    {
        $this->customerTransactionRepository = $customerTransactionRepo;
    }

    /**
     * Display a listing of the CustomerTransaction.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $customerTransactions = $this->customerTransactionRepository->all();

        return view('customer_transactions.index')
            ->with('customerTransactions', $customerTransactions);
    }

    /**
     * Show the form for creating a new CustomerTransaction.
     *
     * @return Response
     */
    public function create()
    {
        return view('customer_transactions.create');
    }

    /**
     * Store a newly created CustomerTransaction in storage.
     *
     * @param CreateCustomerTransactionRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerTransactionRequest $request)
    {
        $input = $request->all();

        $customerTransaction = $this->customerTransactionRepository->create($input);

        Flash::success('Customer Transaction saved successfully.');

        return redirect(route('customerTransactions.index'));
    }

    /**
     * Display the specified CustomerTransaction.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customerTransaction = $this->customerTransactionRepository->find($id);

        if (empty($customerTransaction)) {
            Flash::error('Customer Transaction not found');

            return redirect(route('customerTransactions.index'));
        }

        return view('customer_transactions.show')->with('customerTransaction', $customerTransaction);
    }

    /**
     * Show the form for editing the specified CustomerTransaction.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customerTransaction = $this->customerTransactionRepository->find($id);

        if (empty($customerTransaction)) {
            Flash::error('Customer Transaction not found');

            return redirect(route('customerTransactions.index'));
        }

        return view('customer_transactions.edit')->with('customerTransaction', $customerTransaction);
    }

    /**
     * Update the specified CustomerTransaction in storage.
     *
     * @param int $id
     * @param UpdateCustomerTransactionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerTransactionRequest $request)
    {
        $customerTransaction = $this->customerTransactionRepository->find($id);

        if (empty($customerTransaction)) {
            Flash::error('Customer Transaction not found');

            return redirect(route('customerTransactions.index'));
        }

        $customerTransaction = $this->customerTransactionRepository->update($request->all(), $id);

        Flash::success('Customer Transaction updated successfully.');

        return redirect(route('customerTransactions.index'));
    }

    /**
     * Remove the specified CustomerTransaction from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $customerTransaction = $this->customerTransactionRepository->find($id);

        if (empty($customerTransaction)) {
            Flash::error('Customer Transaction not found');

            return redirect(route('customerTransactions.index'));
        }

        $this->customerTransactionRepository->delete($id);

        Flash::success('Customer Transaction deleted successfully.');

        return redirect(route('customerTransactions.index'));
    }
}
