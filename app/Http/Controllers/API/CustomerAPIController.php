<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCustomerAPIRequest;
use App\Http\Requests\API\UpdateCustomerAPIRequest;
use App\Models\Customer;
use App\Models\CustomerLoan;
use App\Models\CustomerSaving;
use App\Models\LoanRepayment;
use App\Repositories\CustomerRepository;
use App\Utility\Transactions;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\DB;
use Response;

/**
 * Class CustomerController
 * @package App\Http\Controllers\API
 */
class CustomerAPIController extends AppBaseController
{
    /** @var  CustomerRepository */
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepo)
    {
        $this->customerRepository = $customerRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/customers",
     *      summary="Get a listing of the Customers.",
     *      tags={"Customer"},
     *      description="Get all Customers",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Customer")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $customers = $this->customerRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($customers->toArray(), 'Customers retrieved successfully');
    }

    /**
     * @param CreateCustomerAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/customers",
     *      summary="Store a newly created Customer in storage",
     *      tags={"Customer"},
     *      description="Store Customer",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Customer that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Customer")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Customer"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCustomerAPIRequest $request)
    {
        $input = $request->all();

        $customer = $this->customerRepository->create($input);

        return $this->sendResponse($customer->toArray(), 'Customer saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/customers/{id}",
     *      summary="Display the specified Customer",
     *      tags={"Customer"},
     *      description="Get Customer",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Customer",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Customer"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Customer $customer */
        $customer = $this->customerRepository->find($id);

        if (empty($customer)) {
            return $this->sendError('Customer not found');
        }

        return $this->sendResponse($customer->toArray(), 'Customer retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCustomerAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/customers/{id}",
     *      summary="Update the specified Customer in storage",
     *      tags={"Customer"},
     *      description="Update Customer",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Customer",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Customer that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Customer")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Customer"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCustomerAPIRequest $request)
    {
        $input = $request->all();

        /** @var Customer $customer */
        $customer = $this->customerRepository->find($id);

        if (empty($customer)) {
            return $this->sendError('Customer not found');
        }

        $customer = $this->customerRepository->update($input, $id);

        return $this->sendResponse($customer->toArray(), 'Customer updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/customers/{id}",
     *      summary="Remove the specified Customer from storage",
     *      tags={"Customer"},
     *      description="Delete Customer",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Customer",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Customer $customer */
        $customer = $this->customerRepository->find($id);

        if (empty($customer)) {
            return $this->sendError('Customer not found');
        }

        $customer->delete();

        return $this->sendSuccess('Customer deleted successfully');
    }

    public function customerLoans($id)
    {
        $loans = CustomerLoan::with(['loan_application.pv', 'customer'])->whereRaw('customer_id=? AND status=?', [$id, 'RUNNING'])->get();
        return $this->sendResponse($loans, "Customer loans loaded successfully");
    }

    public function customerSavings($customerID)
    {
        $savings = CustomerSaving::with(['savings'])->where('customer_id', $customerID)->get();
        return $this->sendResponse($savings, 'Customer savings loaded successfully.');
    }

    public function loadLoanDetails($loanID)
    {
        $principal = $interest = 0;
        $loanInfo = CustomerLoan::with(['loan_application'])->find($loanID);
        $application = $loanInfo->loan_application;
        if ($application->interest_type == "FLAT_RATE") {
            $principal = $application->repayment_amount;
        } else {
//            $paymentInfo = DB::table('loan_repayments')
//                ->selectRaw('COALESCE(sum(principal),0) as paid,COALESCE(sum(amount_payable),0) as payable')
//                ->where("loan_id", $loanID)->get()->first();
//            $principal = $application->principal - $paymentInfo->paid;
//            $rate = $application->rate / 100;
//            $interest = $principal * $rate;
//            $repayment = $application->repayment_amount + $interest;
            $principal = $application->repayment_amount;
            $interest = Transactions::getLoanInterest($loanID);
        }

        return $this->sendResponse(['principal' => $principal, 'interest' => $interest], "Loan details loaded successfully.");
    }
}
