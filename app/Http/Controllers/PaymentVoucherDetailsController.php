<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaymentVoucherDetailsRequest;
use App\Http\Requests\UpdatePaymentVoucherDetailsRequest;
use App\Repositories\PaymentVoucherDetailsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class PaymentVoucherDetailsController extends AppBaseController
{
    /** @var  PaymentVoucherDetailsRepository */
    private $paymentVoucherDetailsRepository;

    public function __construct(PaymentVoucherDetailsRepository $paymentVoucherDetailsRepo)
    {
        $this->paymentVoucherDetailsRepository = $paymentVoucherDetailsRepo;
    }

    /**
     * Display a listing of the PaymentVoucherDetails.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $paymentVoucherDetails = $this->paymentVoucherDetailsRepository->all();

        return view('payment_voucher_details.index')
            ->with('paymentVoucherDetails', $paymentVoucherDetails);
    }

    /**
     * Show the form for creating a new PaymentVoucherDetails.
     *
     * @return Response
     */
    public function create()
    {
        return view('payment_voucher_details.create');
    }

    /**
     * Store a newly created PaymentVoucherDetails in storage.
     *
     * @param CreatePaymentVoucherDetailsRequest $request
     *
     * @return Response
     */
    public function store(CreatePaymentVoucherDetailsRequest $request)
    {
        $input = $request->all();

        $paymentVoucherDetails = $this->paymentVoucherDetailsRepository->create($input);

        Flash::success('Payment Voucher Details saved successfully.');

        return redirect(route('paymentVoucherDetails.index'));
    }

    /**
     * Display the specified PaymentVoucherDetails.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $paymentVoucherDetails = $this->paymentVoucherDetailsRepository->find($id);

        if (empty($paymentVoucherDetails)) {
            Flash::error('Payment Voucher Details not found');

            return redirect(route('paymentVoucherDetails.index'));
        }

        return view('payment_voucher_details.show')->with('paymentVoucherDetails', $paymentVoucherDetails);
    }

    /**
     * Show the form for editing the specified PaymentVoucherDetails.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $paymentVoucherDetails = $this->paymentVoucherDetailsRepository->find($id);

        if (empty($paymentVoucherDetails)) {
            Flash::error('Payment Voucher Details not found');

            return redirect(route('paymentVoucherDetails.index'));
        }

        return view('payment_voucher_details.edit')->with('paymentVoucherDetails', $paymentVoucherDetails);
    }

    /**
     * Update the specified PaymentVoucherDetails in storage.
     *
     * @param int $id
     * @param UpdatePaymentVoucherDetailsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePaymentVoucherDetailsRequest $request)
    {
        $paymentVoucherDetails = $this->paymentVoucherDetailsRepository->find($id);

        if (empty($paymentVoucherDetails)) {
            Flash::error('Payment Voucher Details not found');

            return redirect(route('paymentVoucherDetails.index'));
        }

        $paymentVoucherDetails = $this->paymentVoucherDetailsRepository->update($request->all(), $id);

        Flash::success('Payment Voucher Details updated successfully.');

        return redirect(route('paymentVoucherDetails.index'));
    }

    /**
     * Remove the specified PaymentVoucherDetails from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $paymentVoucherDetails = $this->paymentVoucherDetailsRepository->find($id);

        if (empty($paymentVoucherDetails)) {
            Flash::error('Payment Voucher Details not found');

            return redirect(route('paymentVoucherDetails.index'));
        }

        $this->paymentVoucherDetailsRepository->delete($id);

        Flash::success('Payment Voucher Details deleted successfully.');

        return redirect(route('paymentVoucherDetails.index'));
    }
}
