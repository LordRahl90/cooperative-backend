<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBankRequest;
use App\Http\Requests\UpdateBankRequest;
use App\Models\Country;
use App\Repositories\BankRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class BankController extends AppBaseController
{
    /** @var  BankRepository */
    private $bankRepository;

    public function __construct(BankRepository $bankRepo)
    {
        $this->bankRepository = $bankRepo;
    }

    /**
     * Display a listing of the Bank.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $banks = $this->bankRepository->all();

        return view('banks.index')
            ->with('banks', $banks);
    }

    /**
     * Show the form for creating a new Bank.
     *
     * @return Response
     */
    public function create()
    {
        $countries = Country::orderBy('name', 'asc')->pluck('name', 'id');
        return view('banks.create', [
            'countries' => $countries
        ]);
    }

    /**
     * Store a newly created Bank in storage.
     *
     * @param CreateBankRequest $request
     *
     * @return Response
     */
    public function store(CreateBankRequest $request)
    {
        $input = $request->all();

        $bank = $this->bankRepository->create($input);

        Flash::success('Bank saved successfully.');

        return redirect(route('banks.index'));
    }

    /**
     * Display the specified Bank.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $bank = $this->bankRepository->find($id);

        if (empty($bank)) {
            Flash::error('Bank not found');

            return redirect(route('banks.index'));
        }

        return view('banks.show')->with('bank', $bank);
    }

    /**
     * Show the form for editing the specified Bank.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $bank = $this->bankRepository->find($id);
        $countries = Country::orderBy('name', 'asc')->pluck('name', 'id');

        if (empty($bank)) {
            Flash::error('Bank not found');

            return redirect(route('banks.index'));
        }

        return view('banks.edit', [
            'countries' => $countries
        ])->with('bank', $bank);
    }

    /**
     * Update the specified Bank in storage.
     *
     * @param int $id
     * @param UpdateBankRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBankRequest $request)
    {
        $bank = $this->bankRepository->find($id);

        if (empty($bank)) {
            Flash::error('Bank not found');

            return redirect(route('banks.index'));
        }

        $bank = $this->bankRepository->update($request->all(), $id);

        Flash::success('Bank updated successfully.');

        return redirect(route('banks.index'));
    }

    /**
     * Remove the specified Bank from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $bank = $this->bankRepository->find($id);

        if (empty($bank)) {
            Flash::error('Bank not found');

            return redirect(route('banks.index'));
        }

        $this->bankRepository->delete($id);

        Flash::success('Bank deleted successfully.');

        return redirect(route('banks.index'));
    }
}
