<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJournalVoucherRequest;
use App\Http\Requests\UpdateJournalVoucherRequest;
use App\Models\Company;
use App\Models\JournalVoucher;
use App\Models\OrgAccountHead;
use App\Repositories\JournalVoucherRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use PDF;
use Response;

class JournalVoucherController extends AppBaseController
{
    /** @var  JournalVoucherRepository */
    private $journalVoucherRepository;

    public function __construct(JournalVoucherRepository $journalVoucherRepo)
    {
        $this->journalVoucherRepository = $journalVoucherRepo;
    }

    /**
     * Display a listing of the JournalVoucher.
     *
     * @param Request $request
     *
     * @param $account
     * @return Response
     */
    public function index(Request $request, $account)
    {
        $companyID = session('company_id');
        $journalVouchers = $this->journalVoucherRepository->where("company_id", $companyID);

        return view('journal_vouchers.index', ['account' => $account])
            ->with('journalVouchers', $journalVouchers);
    }

    /**
     * Show the form for creating a new JournalVoucher.
     *
     * @return Response
     */
    public function create($account)
    {
        $companyID = session('company_id');
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $acctHeads = OrgAccountHead::orderBy("name", 'asc')->where('company_id', $companyID)->pluck("name", "code");

        return view('journal_vouchers.create', [
            'companies' => $companies,
            'accountHeads' => $acctHeads,
            'account' => $account
        ]);
    }

    /**
     * Store a newly created JournalVoucher in storage.
     *
     * @param CreateJournalVoucherRequest $request
     *
     * @return Response
     */
    public function store(CreateJournalVoucherRequest $request, $account)
    {
        $input = $request->all();

        $journalVoucher = $this->journalVoucherRepository->create($input);

        Flash::success('Journal Voucher saved successfully.');

        return redirect(route('journalVouchers.index', $account));
    }

    /**
     * Display the specified JournalVoucher.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($account, $id)
    {
        $journalVoucher = $this->journalVoucherRepository->find($id);

        if (empty($journalVoucher)) {
            Flash::error('Journal Voucher not found');

            return redirect(route('journalVouchers.index'));
        }

        return view('journal_vouchers.show', [
            'account' => $account
        ])->with('journalVoucher', $journalVoucher);
    }

    /**
     * Show the form for editing the specified JournalVoucher.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($account, $id)
    {
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        // Use the company to load content
        $acctHeads = OrgAccountHead::orderBy("name", 'asc')->pluck("name", "code");

        $journalVoucher = $this->journalVoucherRepository->find($id);

        if (empty($journalVoucher)) {
            Flash::error('Journal Voucher not found');

            return redirect(route('journalVouchers.index'));
        }

        return view('journal_vouchers.edit', [
            'companies' => $companies,
            'accountHeads' => $acctHeads,
            'account' => $account
        ])->with('journalVoucher', $journalVoucher);
    }

    /**
     * Update the specified JournalVoucher in storage.
     *
     * @param int $id
     * @param UpdateJournalVoucherRequest $request
     *
     * @return Response
     */
    public function update($account, $id, UpdateJournalVoucherRequest $request)
    {
        $journalVoucher = $this->journalVoucherRepository->find($id);

        if (empty($journalVoucher)) {
            Flash::error('Journal Voucher not found');

            return redirect(route('journalVouchers.index', $account));
        }

        $journalVoucher = $this->journalVoucherRepository->update($request->all(), $id);

        Flash::success('Journal Voucher updated successfully.');

        return redirect(route('journalVouchers.index', $account));
    }

    /**
     * Remove the specified JournalVoucher from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($account, $id)
    {
        $journalVoucher = $this->journalVoucherRepository->find($id);

        if (empty($journalVoucher)) {
            Flash::error('Journal Voucher not found');

            return redirect(route('journalVouchers.index', $account));
        }

        $this->journalVoucherRepository->delete($id);

        Flash::success('Journal Voucher deleted successfully.');

        return redirect(route('journalVouchers.index', $account));
    }

    public function printJV($reference)
    {
        $reference = decrypt($reference);
        $jv = JournalVoucher::with('transactions')->where('reference', $reference)->get();
        if (count($jv) == 0) {
            Flash::error("Invalid JV reference number");
            return redirect()->back()->withInput();
        }
        $jv = $jv->first();
        $pdf = PDF::loadView('journal_vouchers.print_out', [
            'details' => $jv
        ],
            ['title' => 'Journal Voucher Summary']);
        return $pdf->stream($reference . '.pdf');
    }

    public function showReprintJV($account)
    {
        return view('journal_vouchers.reprint', ['account' => $account]);
    }

    public function reprintJV(Request $request)
    {
        $input = $request->all();
        $reference = $input['reference'];
        $jv = JournalVoucher::with('transactions')->where('reference', $reference)->get();
        if (count($jv) == 0) {
            Flash::error("Invalid JV reference number");
            return redirect()->back()->withInput();
        }
        $jv = $jv->first();
        $pdf = PDF::loadView('journal_vouchers.print_out', [
            'details' => $jv
        ],
            ['title' => 'Journal Voucher Summary']);
        return $pdf->stream($reference . '.pdf');
    }
}
