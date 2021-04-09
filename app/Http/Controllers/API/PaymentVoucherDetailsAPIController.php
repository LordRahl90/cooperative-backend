<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePaymentVoucherDetailsAPIRequest;
use App\Http\Requests\API\UpdatePaymentVoucherDetailsAPIRequest;
use App\Models\PaymentVoucherDetails;
use App\Repositories\PaymentVoucherDetailsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class PaymentVoucherDetailsController
 * @package App\Http\Controllers\API
 */

class PaymentVoucherDetailsAPIController extends AppBaseController
{
    /** @var  PaymentVoucherDetailsRepository */
    private $paymentVoucherDetailsRepository;

    public function __construct(PaymentVoucherDetailsRepository $paymentVoucherDetailsRepo)
    {
        $this->paymentVoucherDetailsRepository = $paymentVoucherDetailsRepo;
    }

    /**
     * Display a listing of the PaymentVoucherDetails.
     * GET|HEAD /paymentVoucherDetails
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $paymentVoucherDetails = $this->paymentVoucherDetailsRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($paymentVoucherDetails->toArray(), 'Payment Voucher Details retrieved successfully');
    }

    /**
     * Store a newly created PaymentVoucherDetails in storage.
     * POST /paymentVoucherDetails
     *
     * @param CreatePaymentVoucherDetailsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePaymentVoucherDetailsAPIRequest $request)
    {
        $input = $request->all();

        $paymentVoucherDetails = $this->paymentVoucherDetailsRepository->create($input);

        return $this->sendResponse($paymentVoucherDetails->toArray(), 'Payment Voucher Details saved successfully');
    }

    /**
     * Display the specified PaymentVoucherDetails.
     * GET|HEAD /paymentVoucherDetails/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var PaymentVoucherDetails $paymentVoucherDetails */
        $paymentVoucherDetails = $this->paymentVoucherDetailsRepository->find($id);

        if (empty($paymentVoucherDetails)) {
            return $this->sendError('Payment Voucher Details not found');
        }

        return $this->sendResponse($paymentVoucherDetails->toArray(), 'Payment Voucher Details retrieved successfully');
    }

    /**
     * Update the specified PaymentVoucherDetails in storage.
     * PUT/PATCH /paymentVoucherDetails/{id}
     *
     * @param int $id
     * @param UpdatePaymentVoucherDetailsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePaymentVoucherDetailsAPIRequest $request)
    {
        $input = $request->all();

        /** @var PaymentVoucherDetails $paymentVoucherDetails */
        $paymentVoucherDetails = $this->paymentVoucherDetailsRepository->find($id);

        if (empty($paymentVoucherDetails)) {
            return $this->sendError('Payment Voucher Details not found');
        }

        $paymentVoucherDetails = $this->paymentVoucherDetailsRepository->update($input, $id);

        return $this->sendResponse($paymentVoucherDetails->toArray(), 'PaymentVoucherDetails updated successfully');
    }

    /**
     * Remove the specified PaymentVoucherDetails from storage.
     * DELETE /paymentVoucherDetails/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var PaymentVoucherDetails $paymentVoucherDetails */
        $paymentVoucherDetails = $this->paymentVoucherDetailsRepository->find($id);

        if (empty($paymentVoucherDetails)) {
            return $this->sendError('Payment Voucher Details not found');
        }

        $paymentVoucherDetails->delete();

        return $this->sendSuccess('Payment Voucher Details deleted successfully');
    }
}
