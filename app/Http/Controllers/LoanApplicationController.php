<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLoanApplicationRequest;
use App\Http\Requests\UpdateLoanApplicationRequest;
use App\Models\Company;
use App\Models\Customer;
use App\Models\LoanAccount;
use App\Models\LoanApplication;
use App\Models\Payment;
use App\Models\PaymentVoucher;
use App\Models\PaymentVoucherDetails;
use App\Repositories\LoanApplicationRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Response;

class LoanApplicationController extends AppBaseController
{
    /** @var  LoanApplicationRepository */
    private $loanApplicationRepository;

    public function __construct(LoanApplicationRepository $loanApplicationRepo)
    {
        $this->loanApplicationRepository = $loanApplicationRepo;
    }

    /**
     * Display a listing of the LoanApplication.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $companyID = session('company_id');
        $loanApplications = $this->loanApplicationRepository->where('company_id', $companyID);

        return view('loan_applications.index')
            ->with('loanApplications', $loanApplications);
    }

    /**
     * Show the form for creating a new LoanApplication.
     *
     * @return Response
     */
    public function create()
    {
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $companyID = session('company_id');
        $customers = Customer::orderBy('surname', 'asc')->where('company_id', $companyID)->get()->pluck('full_name', 'id');
        $loanAccount = LoanAccount::orderBy('name', 'asc')->where('company_id', $companyID)->pluck('name', 'id')->toArray();
        return view('loan_applications.create', [
            'customers' => [0 => 'Select Customer'] + $customers->toArray(),
            'loanAccount' => [0 => 'Select Loan Account'] + $loanAccount
        ]);
    }

    /**
     * Store a newly created LoanApplication in storage.
     *
     * @param CreateLoanApplicationRequest $request
     *
     * @return Response
     */
    public function store(CreateLoanApplicationRequest $request)
    {
        $input = $request->all();

        DB::beginTransaction();
        try {
            if (LoanApplication::whereRaw('customer_id=? AND STATUS=?', [$input['customer_id'], 'PENDING'])->count() > 0) {
                Flash::error("There is a pending loan application for this customer, please process the pending loan before proceeding.");
                return redirect()->back()->withInput();
            }
            //create PV Record
            $loanAccount = LoanAccount::find($input['loan_account_id']);
            $customer = Customer::with(['addresses', 'bank_accounts'])->find($input['customer_id']);
            $address = count($customer->addresses) > 0 ? $customer->addresses[0] : null;
            $bankAccount = count($customer->bank_accounts) > 0 ? $customer->bank_accounts[0] : null;
            $ref = strtoupper(uniqid('LN-'));
            $newPV = PaymentVoucher::create([
                'company_id' => $input['company_id'],
                'payee' => $customer->fullname,
                'address' => $address == null ? "" : $address->street . ', ' . $address->state . ', ' . $address->country,
                'email' => $customer->email,
                'website' => "",
                'phone' => $customer->phone,
                'pv_id' => $ref,
                'account_name' => $bankAccount == null ? "" : $bankAccount->account_name,
                'account_number' => $bankAccount == null ? "" : $bankAccount->account_number,
                'bank_id' => $bankAccount == null ? 0 : $bankAccount->bank_id,
                'status' => "UNPAID",
                'created_by' => auth()->id(),
            ]);

            if (!$newPV) {
                throw new \Exception("cannot create PV details.");
            }

            $input['pv_id'] = $newPV->id;

            $newItem = PaymentVoucherDetails::create([
                'company_id' => $input['company_id'],
                'pv_id' => $newPV->id,
                'account_head_id' => $loanAccount->account_head_id,
                'narration' => "New Loan for " . $customer->full_name,
                'rate' => 1,
                'quantity' => 1,
                'amount' => $input['principal']
            ]);

            if (!$newItem) {
                throw new \Exception("Cannot create a new PV item");
            }

            $loanApplication = $this->loanApplicationRepository->create($input);
            if (!$loanApplication) {
                throw new \Exception("Cannot create a new loan application record");
            }

            DB::commit();

            return redirect()->to("/paymentVouchers/$ref/details");
        } catch (\Exception $ex) {
            DB::rollBack();
            Flash::error($ex->getMessage());
            dd($ex);

            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified LoanApplication.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $loanApplication = $this->loanApplicationRepository->find($id);

        if (empty($loanApplication)) {
            Flash::error('Loan Application not found');

            return redirect(route('loanApplications.index'));
        }

        return view('loan_applications.show')->with('loanApplication', $loanApplication);
    }

    /**
     * Show the form for editing the specified LoanApplication.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $loanApplication = $this->loanApplicationRepository->find($id);

        if (empty($loanApplication)) {
            Flash::error('Loan Application not found');

            return redirect(route('loanApplications.index'));
        }

        return view('loan_applications.edit')->with('loanApplication', $loanApplication);
    }

    /**
     * Update the specified LoanApplication in storage.
     *
     * @param int $id
     * @param UpdateLoanApplicationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLoanApplicationRequest $request)
    {
        $loanApplication = $this->loanApplicationRepository->find($id);

        if (empty($loanApplication)) {
            Flash::error('Loan Application not found');

            return redirect(route('loanApplications.index'));
        }

        $loanApplication = $this->loanApplicationRepository->update($request->all(), $id);

        Flash::success('Loan Application updated successfully.');

        return redirect(route('loanApplications.index'));
    }

    /**
     * Remove the specified LoanApplication from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $loanApplication = $this->loanApplicationRepository->find($id);

        if (empty($loanApplication)) {
            Flash::error('Loan Application not found');

            return redirect(route('loanApplications.index'));
        }

        $this->loanApplicationRepository->delete($id);

        Flash::success('Loan Application deleted successfully.');

        return redirect(route('loanApplications.index'));
    }
}
