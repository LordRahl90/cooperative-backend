<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerNextOfKinRequest;
use App\Http\Requests\UpdateCustomerNextOfKinRequest;
use App\Repositories\CustomerNextOfKinRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class CustomerNextOfKinController extends AppBaseController
{
    /** @var  CustomerNextOfKinRepository */
    private $customerNextOfKinRepository;

    public function __construct(CustomerNextOfKinRepository $customerNextOfKinRepo)
    {
        $this->customerNextOfKinRepository = $customerNextOfKinRepo;
    }

    /**
     * Display a listing of the CustomerNextOfKin.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $customerNextOfKins = $this->customerNextOfKinRepository->all();

        return view('customer_next_of_kins.index')
            ->with('customerNextOfKins', $customerNextOfKins);
    }

    /**
     * Show the form for creating a new CustomerNextOfKin.
     *
     * @return Response
     */
    public function create()
    {
        return view('customer_next_of_kins.create');
    }

    /**
     * Store a newly created CustomerNextOfKin in storage.
     *
     * @param CreateCustomerNextOfKinRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerNextOfKinRequest $request)
    {
        $input = $request->all();

        $customerNextOfKin = $this->customerNextOfKinRepository->create($input);

        Flash::success('Customer Next Of Kin saved successfully.');

        return redirect(route('customerNextOfKins.index'));
    }

    /**
     * Display the specified CustomerNextOfKin.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customerNextOfKin = $this->customerNextOfKinRepository->find($id);

        if (empty($customerNextOfKin)) {
            Flash::error('Customer Next Of Kin not found');

            return redirect(route('customerNextOfKins.index'));
        }

        return view('customer_next_of_kins.show')->with('customerNextOfKin', $customerNextOfKin);
    }

    /**
     * Show the form for editing the specified CustomerNextOfKin.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customerNextOfKin = $this->customerNextOfKinRepository->find($id);

        if (empty($customerNextOfKin)) {
            Flash::error('Customer Next Of Kin not found');

            return redirect(route('customerNextOfKins.index'));
        }

        return view('customer_next_of_kins.edit')->with('customerNextOfKin', $customerNextOfKin);
    }

    /**
     * Update the specified CustomerNextOfKin in storage.
     *
     * @param int $id
     * @param UpdateCustomerNextOfKinRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerNextOfKinRequest $request)
    {
        $customerNextOfKin = $this->customerNextOfKinRepository->find($id);

        if (empty($customerNextOfKin)) {
            Flash::error('Customer Next Of Kin not found');

            return redirect(route('customerNextOfKins.index'));
        }

        $customerNextOfKin = $this->customerNextOfKinRepository->update($request->all(), $id);

        Flash::success('Customer Next Of Kin updated successfully.');

        return redirect(route('customerNextOfKins.index'));
    }

    /**
     * Remove the specified CustomerNextOfKin from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $customerNextOfKin = $this->customerNextOfKinRepository->find($id);

        if (empty($customerNextOfKin)) {
            Flash::error('Customer Next Of Kin not found');

            return redirect(route('customerNextOfKins.index'));
        }

        $this->customerNextOfKinRepository->delete($id);

        Flash::success('Customer Next Of Kin deleted successfully.');

        return redirect(route('customerNextOfKins.index'));
    }
}
