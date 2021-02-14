<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReceiptRequest;
use App\Http\Requests\UpdateReceiptRequest;
use App\Models\Company;
use App\Repositories\ReceiptRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class ReceiptController extends AppBaseController
{
    /** @var  ReceiptRepository */
    private $receiptRepository;

    public function __construct(ReceiptRepository $receiptRepo)
    {
        $this->receiptRepository = $receiptRepo;
    }

    /**
     * Display a listing of the Receipt.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $receipts = $this->receiptRepository->all();

        return view('receipts.index')
            ->with('receipts', $receipts);
    }

    /**
     * Show the form for creating a new Receipt.
     *
     * @return Response
     */
    public function create()
    {
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        return view('receipts.create', [
            'companies' => $companies
        ]);
    }

    /**
     * Store a newly created Receipt in storage.
     *
     * @param CreateReceiptRequest $request
     *
     * @return Response
     */
    public function store(CreateReceiptRequest $request)
    {
        $input = $request->all();

        $receipt = $this->receiptRepository->create($input);

        Flash::success('Receipt saved successfully.');

        return redirect(route('receipts.index'));
    }

    /**
     * Display the specified Receipt.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $receipt = $this->receiptRepository->find($id);

        if (empty($receipt)) {
            Flash::error('Receipt not found');

            return redirect(route('receipts.index'));
        }

        return view('receipts.show')->with('receipt', $receipt);
    }

    /**
     * Show the form for editing the specified Receipt.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $receipt = $this->receiptRepository->find($id);

        if (empty($receipt)) {
            Flash::error('Receipt not found');

            return redirect(route('receipts.index'));
        }

        return view('receipts.edit', [
            'companies' => $companies
        ])->with('receipt', $receipt);
    }

    /**
     * Update the specified Receipt in storage.
     *
     * @param int $id
     * @param UpdateReceiptRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateReceiptRequest $request)
    {
        $receipt = $this->receiptRepository->find($id);

        if (empty($receipt)) {
            Flash::error('Receipt not found');

            return redirect(route('receipts.index'));
        }

        $receipt = $this->receiptRepository->update($request->all(), $id);

        Flash::success('Receipt updated successfully.');

        return redirect(route('receipts.index'));
    }

    /**
     * Remove the specified Receipt from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $receipt = $this->receiptRepository->find($id);

        if (empty($receipt)) {
            Flash::error('Receipt not found');

            return redirect(route('receipts.index'));
        }

        $this->receiptRepository->delete($id);

        Flash::success('Receipt deleted successfully.');

        return redirect(route('receipts.index'));
    }

    public function showReprintReceipt()
    {
        return view('receipts.reprint');
    }

    public function reprintReceipt(Request $request)
    {
        $input = $request->all();
        $reference = encrypt($input['reference']);
        return response()->redirectTo("/income/$reference/receipt");
    }
}
