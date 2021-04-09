<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CustomerLoanLog;

class CustomerLoanLogApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_customer_loan_log()
    {
        $customerLoanLog = CustomerLoanLog::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/customer_loan_logs', $customerLoanLog
        );

        $this->assertApiResponse($customerLoanLog);
    }

    /**
     * @test
     */
    public function test_read_customer_loan_log()
    {
        $customerLoanLog = CustomerLoanLog::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/customer_loan_logs/'.$customerLoanLog->id
        );

        $this->assertApiResponse($customerLoanLog->toArray());
    }

    /**
     * @test
     */
    public function test_update_customer_loan_log()
    {
        $customerLoanLog = CustomerLoanLog::factory()->create();
        $editedCustomerLoanLog = CustomerLoanLog::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/customer_loan_logs/'.$customerLoanLog->id,
            $editedCustomerLoanLog
        );

        $this->assertApiResponse($editedCustomerLoanLog);
    }

    /**
     * @test
     */
    public function test_delete_customer_loan_log()
    {
        $customerLoanLog = CustomerLoanLog::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/customer_loan_logs/'.$customerLoanLog->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/customer_loan_logs/'.$customerLoanLog->id
        );

        $this->response->assertStatus(404);
    }
}
