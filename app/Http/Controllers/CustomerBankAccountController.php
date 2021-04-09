<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerBankAccountRequest;
use App\Http\Requests\UpdateCustomerBankAccountRequest;
use App\Repositories\CustomerBankAccountRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class CustomerBankAccountController extends AppBaseController
{
    /** @var  CustomerBankAccountRepository */
    private $customerBankAccountRepository;

    public function __construct(CustomerBankAccountRepository $customerBankAccountRepo)
    {
        $this->customerBankAccountRepository = $customerBankAccountRepo;
    }

    /**
     * Display a listing of the CustomerBankAccount.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $customerBankAccounts = $this->customerBankAccountRepository->all();

        return view('customer_bank_accounts.index')
            ->with('customerBankAccounts', $customerBankAccounts);
    }

    /**
     * Show the form for creating a new CustomerBankAccount.
     *
     * @return Response
     */
    public function create()
    {
        return view('customer_bank_accounts.create');
    }

    /**
     * Store a newly created CustomerBankAccount in storage.
     *
     * @param CreateCustomerBankAccountRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerBankAccountRequest $request)
    {
        $input = $request->all();

        $customerBankAccount = $this->customerBankAccountRepository->create($input);

        Flash::success('Customer Bank Account saved successfully.');

        return redirect(route('customerBankAccounts.index'));
    }

    /**
     * Display the specified CustomerBankAccount.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customerBankAccount = $this->customerBankAccountRepository->find($id);

        if (empty($customerBankAccount)) {
            Flash::error('Customer Bank Account not found');

            return redirect(route('customerBankAccounts.index'));
        }

        return view('customer_bank_accounts.show')->with('customerBankAccount', $customerBankAccount);
    }

    /**
     * Show the form for editing the specified CustomerBankAccount.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customerBankAccount = $this->customerBankAccountRepository->find($id);

        if (empty($customerBankAccount)) {
            Flash::error('Customer Bank Account not found');

            return redirect(route('customerBankAccounts.index'));
        }

        return view('customer_bank_accounts.edit')->with('customerBankAccount', $customerBankAccount);
    }

    /**
     * Update the specified CustomerBankAccount in storage.
     *
     * @param int $id
     * @param UpdateCustomerBankAccountRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerBankAccountRequest $request)
    {
        $customerBankAccount = $this->customerBankAccountRepository->find($id);

        if (empty($customerBankAccount)) {
            Flash::error('Customer Bank Account not found');

            return redirect(route('customerBankAccounts.index'));
        }

        $customerBankAccount = $this->customerBankAccountRepository->update($request->all(), $id);

        Flash::success('Customer Bank Account updated successfully.');

        return redirect(route('customerBankAccounts.index'));
    }

    /**
     * Remove the specified CustomerBankAccount from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $customerBankAccount = $this->customerBankAccountRepository->find($id);

        if (empty($customerBankAccount)) {
            Flash::error('Customer Bank Account not found');

            return redirect(route('customerBankAccounts.index'));
        }

        $this->customerBankAccountRepository->delete($id);

        Flash::success('Customer Bank Account deleted successfully.');

        return redirect(route('customerBankAccounts.index'));
    }
}
