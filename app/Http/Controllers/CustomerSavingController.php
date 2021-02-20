<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerSavingRequest;
use App\Http\Requests\UpdateCustomerSavingRequest;
use App\Repositories\CustomerSavingRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class CustomerSavingController extends AppBaseController
{
    /** @var  CustomerSavingRepository */
    private $customerSavingRepository;

    public function __construct(CustomerSavingRepository $customerSavingRepo)
    {
        $this->customerSavingRepository = $customerSavingRepo;
    }

    /**
     * Display a listing of the CustomerSaving.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $customerSavings = $this->customerSavingRepository->all();

        return view('customer_savings.index')
            ->with('customerSavings', $customerSavings);
    }

    /**
     * Show the form for creating a new CustomerSaving.
     *
     * @return Response
     */
    public function create()
    {
        return view('customer_savings.create');
    }

    /**
     * Store a newly created CustomerSaving in storage.
     *
     * @param CreateCustomerSavingRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerSavingRequest $request)
    {
        $input = $request->all();

        $customerSaving = $this->customerSavingRepository->create($input);

        Flash::success('Customer Saving saved successfully.');

        return redirect(route('customerSavings.index'));
    }

    /**
     * Display the specified CustomerSaving.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customerSaving = $this->customerSavingRepository->find($id);

        if (empty($customerSaving)) {
            Flash::error('Customer Saving not found');

            return redirect(route('customerSavings.index'));
        }

        return view('customer_savings.show')->with('customerSaving', $customerSaving);
    }

    /**
     * Show the form for editing the specified CustomerSaving.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customerSaving = $this->customerSavingRepository->find($id);

        if (empty($customerSaving)) {
            Flash::error('Customer Saving not found');

            return redirect(route('customerSavings.index'));
        }

        return view('customer_savings.edit')->with('customerSaving', $customerSaving);
    }

    /**
     * Update the specified CustomerSaving in storage.
     *
     * @param int $id
     * @param UpdateCustomerSavingRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerSavingRequest $request)
    {
        $customerSaving = $this->customerSavingRepository->find($id);

        if (empty($customerSaving)) {
            Flash::error('Customer Saving not found');

            return redirect(route('customerSavings.index'));
        }

        $customerSaving = $this->customerSavingRepository->update($request->all(), $id);

        Flash::success('Customer Saving updated successfully.');

        return redirect(route('customerSavings.index'));
    }

    /**
     * Remove the specified CustomerSaving from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $customerSaving = $this->customerSavingRepository->find($id);

        if (empty($customerSaving)) {
            Flash::error('Customer Saving not found');

            return redirect(route('customerSavings.index'));
        }

        $this->customerSavingRepository->delete($id);

        Flash::success('Customer Saving deleted successfully.');

        return redirect(route('customerSavings.index'));
    }
}
