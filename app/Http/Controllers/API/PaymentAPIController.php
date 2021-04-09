<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePaymentAPIRequest;
use App\Http\Requests\API\UpdatePaymentAPIRequest;
use App\Models\Payment;
use App\Models\Transaction;
use App\Repositories\PaymentRepository;
use App\Utility\JournalVoucher;
use App\Utility\Transactions;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Response;

/**
 * Class PaymentController
 * @package App\Http\Controllers\API
 */
class PaymentAPIController extends AppBaseController
{
    /** @var  PaymentRepository */
    private $paymentRepository;

    public function __construct(PaymentRepository $paymentRepo)
    {
        $this->paymentRepository = $paymentRepo;
    }

    /**
     * Display a listing of the Payment.
     * GET|HEAD /payments
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $payments = $this->paymentRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($payments->toArray(), 'Payments retrieved successfully');
    }

    /**
     * Store a newly created Payment in storage.
     * POST /payments
     *
     * @param CreatePaymentAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePaymentAPIRequest $request)
    {
        $input = $request->all();

        $payment = $this->paymentRepository->create($input);

        return $this->sendResponse($payment->toArray(), 'Payment saved successfully');
    }

    /**
     * Display the specified Payment.
     * GET|HEAD /payments/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Payment $payment */
        $payment = $this->paymentRepository->find($id);

        if (empty($payment)) {
            return $this->sendError('Payment not found');
        }

        return $this->sendResponse($payment->toArray(), 'Payment retrieved successfully');
    }

    /**
     * Update the specified Payment in storage.
     * PUT/PATCH /payments/{id}
     *
     * @param int $id
     * @param UpdatePaymentAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePaymentAPIRequest $request)
    {
        $input = $request->all();

        /** @var Payment $payment */
        $payment = $this->paymentRepository->find($id);

        if (empty($payment)) {
            return $this->sendError('Payment not found');
        }

        $payment = $this->paymentRepository->update($input, $id);

        return $this->sendResponse($payment->toArray(), 'Payment updated successfully');
    }

    /**
     * Remove the specified Payment from storage.
     * DELETE /payments/{id}
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var Payment $payment */
        $payment = $this->paymentRepository->find($id);

        if (empty($payment)) {
            return $this->sendError('Payment not found');
        }

        $payment->delete();

        return $this->sendSuccess('Payment deleted successfully');
    }

    public function postJournalVoucher(Request $request)
    {
        $input = $request->all();
        $v = Validator::make($input, [
            'company_id' => 'required|exists:companies,id',
            'narration' => 'required',
            'reference' => 'required|unique:transactions,reference',
            'credit' => 'required',
            'debit' => 'required',
            'user_id' => 'required'
        ]);
        if ($v->fails()) {
            return $this->sendError($v->messages()->all(), 400);
        }
        try {
            $userID = $input['user_id']; //TODO: Use authenticated user information here.
            $trans = new JournalVoucher();
            $jv = $trans->create($input['company_id'], $input['reference'], $input['narration'], $input['credit'], $input['debit'], $userID);
            Log::info($jv);
            return $this->sendResponse($jv, "JV Posted successfully");
        } catch (\Exception $ex) {
            Log::error($ex);;
            return $this->sendError($ex->getMessage(), 500);
        }
    }
}
