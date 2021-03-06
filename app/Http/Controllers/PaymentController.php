<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Bank;
use App\Models\Company;
use App\Models\OrgAccountHead;
use App\Models\OrgBankAccount;
use App\Models\PaymentVoucher;
use App\Models\Staff;
use App\Models\Transaction;
use App\Repositories\PaymentRepository;
use App\Http\Controllers\AppBaseController;
use App\Utility\Transactions;
use Illuminate\Http\Request;
use Flash;
use PDF;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Response;

class PaymentController extends AppBaseController
{
    /** @var  PaymentRepository */
    private $paymentRepository;

    public function __construct(PaymentRepository $paymentRepo)
    {
        $this->paymentRepository = $paymentRepo;
    }

    /**
     * Display a listing of the Payment.
     *
     * @param Request $request
     *
     * @param $account
     * @return Response
     */
    public function index(Request $request, $account)
    {
        $companyID = session('company_id');
        $payments = $this->paymentRepository->where("company_id", $companyID);

        return view('payments.index', ['account' => $account])
            ->with('payments', $payments);
    }

    /**
     * Show the form for creating a new Payment.
     *
     * @param $account
     * @return Response
     */
    public function create($account)
    {
        $companyID = session('company_id');
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $bankAccounts = OrgBankAccount::orderBy('account_name', 'asc')->where('company_id', $companyID)->pluck('account_name', 'id')->toArray();
        $staff = Staff::orderBy('name', 'asc')->where('company_id', $companyID)->pluck('name', 'id')->toArray();
        $pvs = PaymentVoucher::orderBy('pv_id', 'asc')->where('status', 'UNPAID')->where('company_id', $companyID)->pluck('pv_id', 'id')->toArray();
        return view('payments.create', [
            'companies' => [0 => 'Select Company'] + $companies,
            'bankAccounts' => [0 => 'Select Bank Account'] + $bankAccounts,
            'staff' => [0 => 'Select Staff'] + $staff,
            'pvs' => [0 => "Select PV"] + $pvs,
            'account' => $account
        ]);
    }

    /**
     * Store a newly created Payment in storage.
     *
     * @param CreatePaymentRequest $request
     *
     * @param $account
     * @return Response
     */
    public function store(CreatePaymentRequest $request, $account)
    {
        $input = $request->all();
        try {
            $pvID = $input['pv_id'];
            $companyID = $input['company_id'];
            $bankAccount = $input['debit_account'];
            $totalAmount = $input['total_amount'];
            $reference = $input['reference'];
            $narration = $input['narration'];
            $authorizedBy = $input['authorized_by'];
            $confirmedBy = $input['confirmed_by'];

            Transactions::makePayment($companyID, $pvID, $bankAccount, $reference, $narration, $totalAmount, $confirmedBy, $authorizedBy, auth()->id());

        } catch (\Exception $ex) {
            Log::error($ex);
            Flash::error($ex->getMessage());
            return redirect()->back()->withInput();
        }
        Flash::success("Payment registered successfully.");
        return redirect(route('payments.index', $account));
    }

    /**
     * Display the specified Payment.
     *
     * @param $account
     * @param int $id
     *
     * @return Response
     */
    public function show($account, $id)
    {
        $payment = $this->paymentRepository->find($id);

        if (empty($payment)) {
            Flash::error('Payment not found');

            return redirect(route('payments.index', $account));
        }

        return view('payments.show', ['account' => $account])->with('payment', $payment);
    }

    /**
     * Show the form for editing the specified Payment.
     *
     * @param $account
     * @param int $id
     *
     * @return Response
     */
    public function edit($account, $id)
    {
        $payment = $this->paymentRepository->find($id);

        if (empty($payment)) {
            Flash::error('Payment not found');

            return redirect(route('payments.index', $account));
        }

        return view('payments.edit', ['account' => $account])->with('payment', $payment);
    }

    /**
     * Update the specified Payment in storage.
     *
     * @param $account
     * @param int $id
     * @param UpdatePaymentRequest $request
     *
     * @return Response
     */
    public function update($account, $id, UpdatePaymentRequest $request)
    {
        $payment = $this->paymentRepository->find($id);

        if (empty($payment)) {
            Flash::error('Payment not found');

            return redirect(route('payments.index'));
        }

        $payment = $this->paymentRepository->update($request->all(), $id);

        Flash::success('Payment updated successfully.');

        return redirect(route('payments.index', $account));
    }

    /**
     * Remove the specified Payment from storage.
     *
     * @param $account
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     */
    public function destroy($account, $id)
    {
        $payment = $this->paymentRepository->find($id);

        if (empty($payment)) {
            Flash::error('Payment not found');

            return redirect(route('payments.index'));
        }

        $this->paymentRepository->delete($id);

        Flash::success('Payment deleted successfully.');

        return redirect(route('payments.index', $account));
    }

    /**
     * @param $account
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showCreateIncome($account)
    {
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $bankAccounts = OrgBankAccount::orderBy('account_name', 'asc')->pluck('account_name', 'account_head_id');
        $acctHeadIDs = [];
        foreach ($bankAccounts as $k => $v) {
            $acctHeadIDs[] = $k;
        }
        //TODO: use the code below to sorth account head by companies.
        $acctHeads = OrgAccountHead::orderBy("name", 'asc')->whereNotIn('id', $acctHeadIDs)->pluck("name", "id");

        return view("payments.income", [
            'companies' => [0 => 'Select Company'] + $companies,
            'bankAccounts' => [0 => 'Select Bank Account'] + $bankAccounts->toArray(),
            'acctHeads' => $acctHeads,
            'account' => $account
        ]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createIncome(Request $request, $account)
    {
        $v = Validator::make($request->all(), [
            'company_id' => 'required|exists:companies,id',
            'reference' => 'required|unique:transactions,reference',
            'bank_account' => 'required|exists:org_account_heads,id',
            'account_head' => 'required|exists:org_account_heads,id',
            'narration' => 'required',
            'total_amount' => 'required',
            'payer' => 'required'
        ]);
        $input = $request->all();
        $companyID = $input['company_id'];
        $reference = $input['reference'];
        $narration = $input['narration'];
        $amount = $input['total_amount'];
        $bankAccount = $input['bank_account'];
        $accountHead = $input['account_head'];
        $payer = $input['payer'];
        $phone = $input['phone'];
        $email = $input['email'];

        try {
            Transactions::processIncome($companyID, $accountHead, $bankAccount, $reference, $narration, $amount, $payer, auth()->id(), $phone, $email);
            return response()->redirectTo("/income/{" . encrypt($reference) . "}/receipt");
        } catch (\Exception $ex) {
            Log::error($ex);
            Flash::error($ex->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * @param $account
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function showReceipt($account, $id)
    {
        $id = decrypt($id);
        $details = Transaction::with(['company'])->whereRaw("reference=? and credit_amount>?", [$id, 0.0])->first();
        if ($details == null || $details->receipt == null) {
            Flash::error("invalid receipt reference, please try again.");
            return redirect()->back();
        }

        $pdf = PDF::loadView('payments.receipt', [
            'details' => $details
        ],
            ['title' => 'Income Receipt']);
        return $pdf->stream($details->reference . '.pdf');
    }

    /**
     * @param $account
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showReversePayment($account)
    {
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        return view('payments.reverse', [
            'companies' => $companies,
            'account' => $account
        ]);
    }

    /**
     * @param Request $request
     * @param $account
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reversePayment(Request $request, $account)
    {
        $input = $request->all();
        $v = Validator::make($input, [
            'reference' => 'required|exists:payments,reference',
            'company_id' => 'required|exists:companies,id'
        ]);
        if ($v->fails()) {
            Flash::error(join($v->messages()->all()));
            return redirect()->back()->withInput();
        }
        $reference = $input['reference'];
        $companyID = $input['company_id'];

        try {
            Transactions::reversePayment($companyID, $reference, auth()->id());

        } catch (\Exception $ex) {
            Flash::error($ex->getMessage());
            return redirect()->back()->withInput();
        }
        Flash::success("Payment reversed successfully");
        return redirect()->back();
    }
}
