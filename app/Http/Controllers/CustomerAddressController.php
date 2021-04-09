<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerAddressRequest;
use App\Http\Requests\UpdateCustomerAddressRequest;
use App\Repositories\CustomerAddressRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class CustomerAddressController extends AppBaseController
{
    /** @var  CustomerAddressRepository */
    private $customerAddressRepository;

    public function __construct(CustomerAddressRepository $customerAddressRepo)
    {
        $this->customerAddressRepository = $customerAddressRepo;
    }

    /**
     * Display a listing of the CustomerAddress.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $customerAddresses = $this->customerAddressRepository->all();

        return view('customer_addresses.index')
            ->with('customerAddresses', $customerAddresses);
    }

    /**
     * Show the form for creating a new CustomerAddress.
     *
     * @return Response
     */
    public function create()
    {
        return view('customer_addresses.create');
    }

    /**
     * Store a newly created CustomerAddress in storage.
     *
     * @param CreateCustomerAddressRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerAddressRequest $request)
    {
        $input = $request->all();

        $customerAddress = $this->customerAddressRepository->create($input);

        Flash::success('Customer Address saved successfully.');

        return redirect(route('customerAddresses.index'));
    }

    /**
     * Display the specified CustomerAddress.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customerAddress = $this->customerAddressRepository->find($id);

        if (empty($customerAddress)) {
            Flash::error('Customer Address not found');

            return redirect(route('customerAddresses.index'));
        }

        return view('customer_addresses.show')->with('customerAddress', $customerAddress);
    }

    /**
     * Show the form for editing the specified CustomerAddress.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customerAddress = $this->customerAddressRepository->find($id);

        if (empty($customerAddress)) {
            Flash::error('Customer Address not found');

            return redirect(route('customerAddresses.index'));
        }

        return view('customer_addresses.edit')->with('customerAddress', $customerAddress);
    }

    /**
     * Update the specified CustomerAddress in storage.
     *
     * @param int $id
     * @param UpdateCustomerAddressRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerAddressRequest $request)
    {
        $customerAddress = $this->customerAddressRepository->find($id);

        if (empty($customerAddress)) {
            Flash::error('Customer Address not found');

            return redirect(route('customerAddresses.index'));
        }

        $customerAddress = $this->customerAddressRepository->update($request->all(), $id);

        Flash::success('Customer Address updated successfully.');

        return redirect(route('customerAddresses.index'));
    }

    /**
     * Remove the specified CustomerAddress from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $customerAddress = $this->customerAddressRepository->find($id);

        if (empty($customerAddress)) {
            Flash::error('Customer Address not found');

            return redirect(route('customerAddresses.index'));
        }

        $this->customerAddressRepository->delete($id);

        Flash::success('Customer Address deleted successfully.');

        return redirect(route('customerAddresses.index'));
    }
}
