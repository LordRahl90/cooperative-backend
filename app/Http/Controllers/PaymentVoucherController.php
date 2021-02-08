<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaymentVoucherRequest;
use App\Http\Requests\UpdatePaymentVoucherRequest;
use App\Models\Company;
use App\Repositories\PaymentVoucherRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class PaymentVoucherController extends AppBaseController
{
    /** @var  PaymentVoucherRepository */
    private $paymentVoucherRepository;

    public function __construct(PaymentVoucherRepository $paymentVoucherRepo)
    {
        $this->paymentVoucherRepository = $paymentVoucherRepo;
    }

    /**
     * Display a listing of the PaymentVoucher.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $paymentVouchers = $this->paymentVoucherRepository->all();

        return view('payment_vouchers.index')
            ->with('paymentVouchers', $paymentVouchers);
    }

    /**
     * Show the form for creating a new PaymentVoucher.
     *
     * @return Response
     */
    public function create()
    {
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        return view('payment_vouchers.create', [
            'companies' => $companies
        ]);
    }

    /**
     * Store a newly created PaymentVoucher in storage.
     *
     * @param CreatePaymentVoucherRequest $request
     *
     * @return Response
     */
    public function store(CreatePaymentVoucherRequest $request)
    {
        $input = $request->all();

        $paymentVoucher = $this->paymentVoucherRepository->create($input);

        Flash::success('Payment Voucher saved successfully.');

        return redirect(route('paymentVouchers.index'));
    }

    /**
     * Display the specified PaymentVoucher.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $paymentVoucher = $this->paymentVoucherRepository->find($id);

        if (empty($paymentVoucher)) {
            Flash::error('Payment Voucher not found');

            return redirect(route('paymentVouchers.index'));
        }

        return view('payment_vouchers.show')->with('paymentVoucher', $paymentVoucher);
    }

    /**
     * Show the form for editing the specified PaymentVoucher.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $paymentVoucher = $this->paymentVoucherRepository->find($id);

        if (empty($paymentVoucher)) {
            Flash::error('Payment Voucher not found');

            return redirect(route('paymentVouchers.index'));
        }

        return view('payment_vouchers.edit')->with('paymentVoucher', $paymentVoucher);
    }

    /**
     * Update the specified PaymentVoucher in storage.
     *
     * @param int $id
     * @param UpdatePaymentVoucherRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePaymentVoucherRequest $request)
    {
        $paymentVoucher = $this->paymentVoucherRepository->find($id);

        if (empty($paymentVoucher)) {
            Flash::error('Payment Voucher not found');

            return redirect(route('paymentVouchers.index'));
        }

        $paymentVoucher = $this->paymentVoucherRepository->update($request->all(), $id);

        Flash::success('Payment Voucher updated successfully.');

        return redirect(route('paymentVouchers.index'));
    }

    /**
     * Remove the specified PaymentVoucher from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $paymentVoucher = $this->paymentVoucherRepository->find($id);

        if (empty($paymentVoucher)) {
            Flash::error('Payment Voucher not found');

            return redirect(route('paymentVouchers.index'));
        }

        $this->paymentVoucherRepository->delete($id);

        Flash::success('Payment Voucher deleted successfully.');

        return redirect(route('paymentVouchers.index'));
    }
}
