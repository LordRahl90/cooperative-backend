<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJournalVoucherRequest;
use App\Http\Requests\UpdateJournalVoucherRequest;
use App\Models\Company;
use App\Models\OrgAccountHead;
use App\Repositories\JournalVoucherRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
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
     * @return Response
     */
    public function index(Request $request)
    {
        $journalVouchers = $this->journalVoucherRepository->all();

        return view('journal_vouchers.index')
            ->with('journalVouchers', $journalVouchers);
    }

    /**
     * Show the form for creating a new JournalVoucher.
     *
     * @return Response
     */
    public function create()
    {
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        // Use the company to load content
        $acctHeads = OrgAccountHead::orderBy("name", 'asc')->pluck("name", "code");

        return view('journal_vouchers.create', [
            'companies' => $companies,
            'accountHeads' => $acctHeads
        ]);
    }

    /**
     * Store a newly created JournalVoucher in storage.
     *
     * @param CreateJournalVoucherRequest $request
     *
     * @return Response
     */
    public function store(CreateJournalVoucherRequest $request)
    {
        $input = $request->all();

        $journalVoucher = $this->journalVoucherRepository->create($input);

        Flash::success('Journal Voucher saved successfully.');

        return redirect(route('journalVouchers.index'));
    }

    /**
     * Display the specified JournalVoucher.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $journalVoucher = $this->journalVoucherRepository->find($id);

        if (empty($journalVoucher)) {
            Flash::error('Journal Voucher not found');

            return redirect(route('journalVouchers.index'));
        }

        return view('journal_vouchers.show')->with('journalVoucher', $journalVoucher);
    }

    /**
     * Show the form for editing the specified JournalVoucher.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
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
            'accountHeads' => $acctHeads
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
    public function update($id, UpdateJournalVoucherRequest $request)
    {
        $journalVoucher = $this->journalVoucherRepository->find($id);

        if (empty($journalVoucher)) {
            Flash::error('Journal Voucher not found');

            return redirect(route('journalVouchers.index'));
        }

        $journalVoucher = $this->journalVoucherRepository->update($request->all(), $id);

        Flash::success('Journal Voucher updated successfully.');

        return redirect(route('journalVouchers.index'));
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
    public function destroy($id)
    {
        $journalVoucher = $this->journalVoucherRepository->find($id);

        if (empty($journalVoucher)) {
            Flash::error('Journal Voucher not found');

            return redirect(route('journalVouchers.index'));
        }

        $this->journalVoucherRepository->delete($id);

        Flash::success('Journal Voucher deleted successfully.');

        return redirect(route('journalVouchers.index'));
    }
}
