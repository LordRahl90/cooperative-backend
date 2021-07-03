<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Mail\NewStaffRegistered;
use App\Models\Company;
use App\Models\Staff;
use App\Models\User;
use App\Repositories\StaffRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Response;

class StaffController extends AppBaseController
{
    /** @var  StaffRepository */
    private $staffRepository;

    public function __construct(StaffRepository $staffRepo)
    {
        $this->staffRepository = $staffRepo;
    }

    /**
     * Display a listing of the Staff.
     *
     * @param Request $request
     *
     * @param string $account
     * @return Response
     */
    public function index(Request $request, $account = "")
    {
        $companyID = session('company_id');
        if (isset($companyID)) {
            $staff = $this->staffRepository->where("company_id", $companyID);
        } else {
            $staff = $this->staffRepository->all();
        }


        return view('staff.index', ['account' => $account])
            ->with('staff', $staff);
    }

    /**
     * Show the form for creating a new Staff.
     *
     * @param string $account
     * @return Response
     */
    public function create($account = "")
    {
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        return view('staff.create', [
            'companies' => $companies,
            'account' => $account
        ]);
    }

    /**
     * Store a newly created Staff in storage.
     *
     * @param CreateStaffRequest $request
     *
     * @param string $account
     * @return Response
     */
    public function store(CreateStaffRequest $request, $account = "")
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $check = Staff::whereRaw('company_id=? AND (email=? OR phone=?)',
            [$input['company_id'], $input['email'], $input['phone']])->count();
        if ($check > 0) {
            Flash::error("Staff already exists. do you want to reset their password?");
            return redirect()->back()->withInput();
        }
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'password' => $input['password'],
            'remember_token' => uniqid('rm'),
            'role' => 'STAFF'
        ]);

        $input['user_id'] = $user->id;
        $input['active'] = false;
        $staff = $this->staffRepository->create($input);
        $token = uniqid('tk-');
        $hashedToken = Hash::make($token);

        $company = Company::find($input['company_id']);
        if ($account != "") {
            $link = url('password/reset', $token) . '?email=' . urlencode($staff->user->getEmailForPasswordReset());
        } else {
            $host = explode("://", config('app.url'));
            $link = "https://" . $company->slug . "." . $host[1] . "/password/reset/$token?email="
                . urlencode($staff->user->getEmailForPasswordReset());
        }

        Mail::to($user->email)->queue(new NewStaffRegistered($company, $staff, $request->get('password'), $hashedToken, $link));
        Flash::success('Staff saved successfully.');
//        dispatch(function () use ($user, $company, $staff, $request, $token, $link, $hashedToken) {
//            Mail::to($user->email)->send(new NewStaffRegistered($company, $staff, $request->get('password'), $hashedToken, $link));
//        });//->afterResponse();

        return redirect(route('staff.index', $account));
    }

    /**
     * Display the specified Staff.
     *
     * @param int $id
     *
     * @param string $account
     * @return Response
     */
    public function show($id, $account = "")
    {
        $staff = $this->staffRepository->find($id);

        if (empty($staff)) {
            Flash::error('Staff not found');

            return redirect(route('staff.index'));
        }

        return view('staff.show', [
            'account' => $account
        ])->with('staff', $staff);
    }

    /**
     * Show the form for editing the specified Staff.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id, $account = "")
    {
        $staff = $this->staffRepository->find($id);
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        if (empty($staff)) {
            Flash::error('Staff not found');

            return redirect(route('staff.index'));
        }

        return view('staff.edit', [
            'companies' => $companies,
            'account' => $account
        ])->with('staff', $staff);
    }

    /**
     * Update the specified Staff in storage.
     *
     * @param int $id
     * @param UpdateStaffRequest $request
     *
     * @param string $account
     * @return Response
     */
    public function update($id, UpdateStaffRequest $request, $account = "")
    {
        $staff = $this->staffRepository->find($id);

        if (empty($staff)) {
            Flash::error('Staff not found');

            return redirect(route('staff.index'));
        }

        $staff = $this->staffRepository->update($request->all(), $id);

        Flash::success('Staff updated successfully.');

        return redirect(route('staff.index', [
            'account' => $account
        ]));
    }

    /**
     * Remove the specified Staff from storage.
     *
     * @param int $id
     *
     * @param string $account
     * @return Response
     * @throws \Exception
     */
    public function destroy($account, $id)
    {
        $staff = $this->staffRepository->find($id);

        if (empty($staff)) {
            Flash::error('Staff not found');

            return redirect(route('staff.index', $account));
        }

        $this->staffRepository->delete($id);

        Flash::success('Staff deleted successfully.');

        return redirect(route('staff.index', $account));
    }
}
