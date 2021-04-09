<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePaymentVoucherAPIRequest;
use App\Http\Requests\API\UpdatePaymentVoucherAPIRequest;
use App\Models\PaymentVoucher;
use App\Models\PaymentVoucherDetails;
use App\Repositories\PaymentVoucherRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        $details = $input['details'];
        $items = $input['items'];

        if (PaymentVoucher::where("pv_id", $details['id'])->count() > 0) {
            return $this->sendError("This PV already exists", 400);
        }

        DB::beginTransaction();
        try {
            $newPV = PaymentVoucher::create([
                'company_id' => $details['company_id'],
                'payee' => $details['payee'],
                'address' => $details['address'],
                'email' => $details['email'],
                'website' => $details['website'],
                'phone' => $details['phone'],
                'pv_id' => $details['id'],
                'account_name' => $details['account_name'],
                'account_number' => $details['account_number'],
                'bank_id' => $details['bank_id'],
                'status' => "UNPAID",
                'created_by' => 1, //TODO: Fix the auth user here.
            ]);

            if (!$newPV) {
                throw new \Exception("cannot create PV details.");
            }

            foreach ($items as $item) {
                $newItem = PaymentVoucherDetails::create([
                    'company_id' => $details['company_id'],
                    'pv_id' => $newPV->id,
                    'account_head_id' => $item['account_head_id'],
                    'narration' => $item['narration'],
                    'rate' => $item['rate'],
                    'quantity' => $item['quantity'],
                    'amount' => $item['amount']
                ]);

                if (!$newItem) {
                    Log::info($item);
                    throw new \Exception("Cannot create a new item");
                }
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::info($ex);
            return $this->sendError($ex->getMessage(), 500);
        }

        Log::info("Hello world");

        DB::commit();
        return $this->sendSuccess("Payment Voucher created successfully.");
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
     * @return Response
     * @throws \Exception
     *
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

    public function loadPVDetails($id)
    {
        $pvs = PaymentVoucher::with(['company', 'items','items.accountHead'])->find($id);
        return $this->sendResponse($pvs, "PV details loaded successfully");
    }
}
