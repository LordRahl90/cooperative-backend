<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaymentVoucherRequest;
use App\Http\Requests\UpdatePaymentVoucherRequest;
use App\Models\Bank;
use App\Models\Company;
use App\Models\OrgAccountHead;
use App\Models\PaymentVoucher;
use App\Repositories\PaymentVoucherRepository;
use App\Http\Controllers\AppBaseController;
use App\Utility\Invoice;
use App\Utility\NumberConversion;
use App\Utility\PhpTest;
use App\Utility\PhpTester;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Storage;
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
        $companyID = session('company_id');
        $paymentVouchers = $this->paymentVoucherRepository->where("company_id", $companyID);

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
        //TODO: Abiodun, sort the account heads with login companies
        $accountHeads = OrgAccountHead::orderBy('name', 'asc')->pluck('name', 'id');
        $banks = Bank::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        return view('payment_vouchers.create', [
            'companies' => [0 => 'Select Account'] + $companies->toArray(),
            'banks' => $banks
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

    /**
     * @param $id
     * @return mixed
     */
    public function printPV($id)
    {
        $amount = 0;
        $pv = PaymentVoucher::with(['items', 'company'])->where("pv_id", $id)->get()->first();
        $pdf = new Invoice('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->watermark(strtoupper($pv->company->name));
        $pdf->addCompanyAddress($pv->company->name,
            $pv->company->address . "\n" .
            $pv->company->phone . "\n" .
            $pv->company->email . "\n" .
            $pv->company->website);

        $pdf->addDate($pv->status);

        $pdf->addClientAdresse($pv->payee .
            "\n" . $pv->address .
            "\n" . $pv->phone .
            "\n" . $pv->email .
            "\n" . $pv->website);
        $pdf->addReglement("");
        $pdf->addCreatedDate(Date('Y-m-d', strtotime($pv->created_at)));
        $pdf->addPVID($pv->pv_id);
        $pdf->addReference("\nYour REF.................................");

        $cols = array(
            "SN" => 15,
            "Description" => 78,
            "Code" => 20,
            "Rate" => 20,
            "Quantity" => 20,
            "Amount" => 30,
        );
        $pdf->addCols($cols);
        $cols = array("SN" => "C",
            "Description" => "L",
            "Code" => "C",
            "Rate" => "R",
            "Quantity" => 'R',
            "Amount" => "R",
        );
        $pdf->addLineFormat($cols);
        $y = 109;

        foreach ($pv->items as $k => $item) {
            $amount += $item->amount;
            $line = array("SN" => $k + 1,
                "Description" => $item->narration,
                "Code" => $item->accountHead->code,
                "Rate" => number_format($item->rate, 2),
                "Quantity" => number_format($item->quantity, 2),
                "Amount" => number_format($item->amount, 2),
            );
            $size = $pdf->addLine($y, $line);
            $y += $size + 2;
        }
        $line = array("SN" => "T",
            "Description" => "Total",
            "Code" => "Total",
            "Rate" => "Total",
            "Quantity" => "Total",
            "Amount" => number_format($amount, 2),
        );
        $pdf->addReglement(number_format($amount, 2));
        $size = $pdf->addLine($y, $line);
        $y += $size + 2;
        $pdf->addCadreTVAs();
        $psp = NumberConversion::convert_number_to_words($amount);
        $pdf->MultiCell(150, 4, "Payment is hereby authorised for " . $psp . " naira only, in respect of the above stated service(s).
        \n\n........................................................... \n\n" .
            "Approved By(Name, Signature and Date)\n\n..........................................................." . "
        \nAuthorized By(Name, Signature and Date)\n\n...................................................." .
            "\nFor: Payee");
        $path = $pv->pv_id . ".pdf";
        Storage::put("pv/" . $path, $pdf->Output('S', $id . '.pdf', true));
        return Storage::download("/pv/" . $path);
    }

    public function showReprintPV()
    {
        return view('payment_vouchers.reprint');
    }

    public function reprintPV(Request $request)
    {
        $input = $request->all();
        $pvID = $input['pv_id'];
        return response()->redirectTo("/paymentVouchers/$pvID/details");
    }
}
