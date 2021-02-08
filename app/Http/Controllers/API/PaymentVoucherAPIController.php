<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePaymentVoucherAPIRequest;
use App\Http\Requests\API\UpdatePaymentVoucherAPIRequest;
use App\Models\PaymentVoucher;
use App\Repositories\PaymentVoucherRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class PaymentVoucherController
 * @package App\Http\Controllers\API
 */

class PaymentVoucherAPIController extends AppBaseController
{
    /** @var  PaymentVoucherRepository */
    private $paymentVoucherRepository;

    public function __construct(PaymentVoucherRepository $paymentVoucherRepo)
    {
        $this->paymentVoucherRepository = $paymentVoucherRepo;
    }

    /**
     * Display a listing of the PaymentVoucher.
     * GET|HEAD /paymentVouchers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $paymentVouchers = $this->paymentVoucherRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($paymentVouchers->toArray(), 'Payment Vouchers retrieved successfully');
    }

    /**
     * Store a newly created PaymentVoucher in storage.
     * POST /paymentVouchers
     *
     * @param CreatePaymentVoucherAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePaymentVoucherAPIRequest $request)
    {
        $input = $request->all();

        $paymentVoucher = $this->paymentVoucherRepository->create($input);

        return $this->sendResponse($paymentVoucher->toArray(), 'Payment Voucher saved successfully');
    }

    /**
     * Display the specified PaymentVoucher.
     * GET|HEAD /paymentVouchers/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var PaymentVoucher $paymentVoucher */
        $paymentVoucher = $this->paymentVoucherRepository->find($id);

        if (empty($paymentVoucher)) {
            return $this->sendError('Payment Voucher not found');
        }

        return $this->sendResponse($paymentVoucher->toArray(), 'Payment Voucher retrieved successfully');
    }

    /**
     * Update the specified PaymentVoucher in storage.
     * PUT/PATCH /paymentVouchers/{id}
     *
     * @param int $id
     * @param UpdatePaymentVoucherAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePaymentVoucherAPIRequest $request)
    {
        $input = $request->all();

        /** @var PaymentVoucher $paymentVoucher */
        $paymentVoucher = $this->paymentVoucherRepository->find($id);

        if (empty($paymentVoucher)) {
            return $this->sendError('Payment Voucher not found');
        }

        $paymentVoucher = $this->paymentVoucherRepository->update($input, $id);

        return $this->sendResponse($paymentVoucher->toArray(), 'PaymentVoucher updated successfully');
    }

    /**
     * Remove the specified PaymentVoucher from storage.
     * DELETE /paymentVouchers/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var PaymentVoucher $paymentVoucher */
        $paymentVoucher = $this->paymentVoucherRepository->find($id);

        if (empty($paymentVoucher)) {
            return $this->sendError('Payment Voucher not found');
        }

        $paymentVoucher->delete();

        return $this->sendSuccess('Payment Voucher deleted successfully');
    }
}
