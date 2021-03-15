<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Bank;
use App\Models\Company;
use App\Models\Country;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\CustomerBankAccount;
use App\Models\CustomerNextOfKin;
use App\Models\User;
use App\Repositories\CustomerRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Khsing\World\World;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Response;

class CustomerController extends AppBaseController
{
    /** @var  CustomerRepository */
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepo)
    {
        $this->customerRepository = $customerRepo;
    }

    /**
     * Display a listing of the Customer.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $customers = $this->customerRepository->all();

        return view('customers.index')
            ->with('customers', $customers);
    }

    /**
     * Show the form for creating a new Customer.
     *
     * @return Response
     */
    public function create()
    {
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $countries = World::Countries()->sortBy('name')->pluck('name', 'code');
        $banks = Bank::orderBy('name', 'asc')->pluck('name', 'id');
        return view('customers.create', [
            'companies' => $companies,
            'countries' => $countries,
            'banks' => $banks
        ]);
    }

    /**
     * Store a newly created Customer in storage.
     *
     * @param CreateCustomerRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerRequest $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        DB::beginTransaction();
        try {

            $user = User::create([
                'name' => $input['surname'] . ' ' . $input['other_names'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'password' => $input['password'],
                'remember_token' => uniqid('rm'),
                'role' => 'CUSTOMER',
            ]);

            if (!$user) {
                throw new \Exception("cannot create a user account.");
            }

            $customer = Customer::create([
                'company_id' => $input['company_id'],
                'user_id' => $user->id,
                'surname' => $input['surname'],
                'other_names' => $input['other_names'],
                'reference' => $input['reference'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'gender' => $input['gender'],
                'password' => $input['password'],
                'religion' => $input['religion'],
                'dob' => $input['dob']
            ]);

            if (!$customer) {
                throw new \Exception("cannot create customer record successfully.");
            }

            $country = World::getCountryByCode($input['country']);

            $address = CustomerAddress::create([
                'company_id' => $input['company_id'],
                'customer_id' => $customer->id,
                'street' => $input['street'],
                'street2' => $input['street2'],
                'state' => $input['state'],
                'country' => $country->id,
            ]);
            if (!$address) {
                throw new \Exception("cannot create customer's address");
            }

            $bankInfo = CustomerBankAccount::create([
                'company_id' => $input['company_id'],
                'customer_id' => $customer->id,
                'bank_id' => $input['bank_id'],
                'account_name' => $input['account_name'],
                'account_number' => $input['account_number'],
                'sort_code' => $input['sort_code']
            ]);

            if (!$bankInfo) {
                throw new \Exception("cannot save customer's bank information");
            }

            $nokInfo = CustomerNextOfKin::create([
                'company_id' => $input['company_id'],
                'customer_id' => $customer->id,
                'name' => $input['name'],
                'address' => $input['nok_address'],
                'phone' => $input['nok_phone'],
                'email' => $input['nok_email'],
                'relationship' => $input['relationship']
            ]);

            if (!$nokInfo) {
                throw new \Exception("cannot save customer's next-of-kin information");
            }

            DB::commit();
            Flash::success('Customer saved successfully.');
            return redirect(route('customers.index'));

        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex);
            Flash::error($ex->getMessage());
            return redirect()->back()->withInput();
//            dd($ex);
        }
    }

    /**
     * Display the specified Customer.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customer = $this->customerRepository->find($id);

        if (empty($customer)) {
            Flash::error('Customer not found');

            return redirect(route('customers.index'));
        }

        return view('customers.show')->with('customer', $customer);
    }

    /**
     * Show the form for editing the specified Customer.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customer = $this->customerRepository->find($id);
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');

        if (empty($customer)) {
            Flash::error('Customer not found');

            return redirect(route('customers.index'));
        }

        return view('customers.edit', [
            'companies' => $companies
        ])->with('customer', $customer);
    }

    /**
     * Update the specified Customer in storage.
     *
     * @param int $id
     * @param UpdateCustomerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerRequest $request)
    {
        $customer = $this->customerRepository->find($id);

        if (empty($customer)) {
            Flash::error('Customer not found');

            return redirect(route('customers.index'));
        }

        $customer = $this->customerRepository->update($request->all(), $id);

        Flash::success('Customer updated successfully.');

        return redirect(route('customers.index'));
    }

    /**
     * Remove the specified Customer from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $customer = $this->customerRepository->find($id);

        if (empty($customer)) {
            Flash::error('Customer not found');

            return redirect(route('customers.index'));
        }

        $this->customerRepository->delete($id);

        Flash::success('Customer deleted successfully.');

        return redirect(route('customers.index'));
    }

    public function showUpload()
    {
        return view('customers.upload');
    }

    public function upload(Request $request)
    {
        $company = $request->company_id;
        $upload = $request->file('upload');
        if ($upload === null) {
            Flash::error("Invalid customer list, try again.");
            return redirect()->back();
        }

        $filename = uniqid('cus-') . '.xlsx';
        $path = Storage::putFileAs('customers', $upload, $filename);

        $reader = new Xlsx();
        $spreadsheet = $reader->load(storage_path("app/" . $path));
        $sheet = $spreadsheet->getActiveSheet();

        $highestRow = $sheet->getHighestRow();
        for ($row = 2; $row <= $highestRow; $row++) {
            $surname = $sheet->getCellByColumnAndRow(1, $row)->getValue();
            $otherNames = $sheet->getCellByColumnAndRow(2, $row)->getValue();
            $address = $sheet->getCellByColumnAndRow(3, $row)->getValue();
            $state = $sheet->getCellByColumnAndRow(4, $row)->getValue();
            $country = $sheet->getCellByColumnAndRow(5, $row)->getValue();
            $countryInfo = DB::table('world_countries')->where('name', $country)->get();
            if (count($countryInfo) == 0) {
                Log::error("invalid country provided");
                continue;
            }
            $countryInfo = $countryInfo->first();


            $stateInfo = DB::table('world_divisions')->where('country_id', $countryInfo->id)->where('name', $state)->get();
            if (count($stateInfo) == 0) {
                Log::error("Invalid state provided for this country: " . $countryInfo->id);
            }
            $stateInfo = $stateInfo->first();

            $reference = $sheet->getCellByColumnAndRow(6, $row)->getValue();
            $dob = $sheet->getCellByColumnAndRow(7, $row)->getValue();
            $gender = $sheet->getCellByColumnAndRow(8, $row)->getValue();

            $phone = $sheet->getCellByColumnAndRow(13, $row)->getValue();
            $email = $sheet->getCellByColumnAndRow(12, $row)->getValue();
            if ($email == "" || $email == null) {
                $email = strtolower(str_replace(" ", "", ($surname . '' . $otherNames))) . '@coop-backend.test';
            }

            $religion = $sheet->getCellByColumnAndRow(14, $row)->getValue();

            $bankName = $sheet->getCellByColumnAndRow(15, $row)->getValue();
            $accountName = $sheet->getCellByColumnAndRow(16, $row)->getValue();
            $accountNumber = $sheet->getCellByColumnAndRow(17, $row)->getValue();

            $nokName = $sheet->getCellByColumnAndRow(9, $row)->getValue();
            $relationship = $sheet->getCellByColumnAndRow(10, $row)->getValue();
            $nokAddress = $sheet->getCellByColumnAndRow(11, $row)->getValue();
            if ($nokAddress === "AS ABOVE") {
                $nokAddress = $address;
            }

            DB::beginTransaction();
            try {
                $user = User::create([
                    'name' => $surname . ' ' . $otherNames,
                    'email' => $email,
                    'phone' => $phone,
                    'password' => Hash::make('secret'),
                    'role' => 'CUSTOMER',
                ]);
                if (!$user) {
                    Log::error("cannot create user record " . $email . " " . $path);
                    continue;
                }

                $customer = Customer::create([
                    'company_id' => $company,
                    'user_id' => $user->id,
                    'surname' => $surname,
                    'other_names' => $otherNames,
                    'reference' => $reference,
                    'email' => $email,
                    'password' => Hash::make('secret'),
                    'phone' => $phone,
//                    'dob'=>$dob //TODO: Fix the parsing of DOB
                    'gender' => $gender,
                    'religion' => $religion
                ]);
                if (!$customer) {
                    Log::error("cannot create customer record " . $path);
                    continue;
                }

                $address = CustomerAddress::create([
                    'company_id' => $company,
                    'customer_id' => $customer->id,
                    'street' => $address,
                    'street2' => '',
                    'state' => $stateInfo->id,
                    'country' => $countryInfo->id
                ]);
                if (!$address) {
                    Log::error("cannot create customer address information " . $path);
                }



//                $nok = CustomerNextOfKin::create([
//                    'company_id'=>$company,
//                    ''
//                ]);

            } catch (\Exception $ex) {
                Log::error($ex->getMessage());
                DB::rollBack();
            }

        }
    }
}
