<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CustomerLoan;

class CustomerLoanApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_customer_loan()
    {
        $customerLoan = CustomerLoan::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/customer_loans', $customerLoan
        );

        $this->assertApiResponse($customerLoan);
    }

    /**
     * @test
     */
    public function test_read_customer_loan()
    {
        $customerLoan = CustomerLoan::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/customer_loans/'.$customerLoan->id
        );

        $this->assertApiResponse($customerLoan->toArray());
    }

    /**
     * @test
     */
    public function test_update_customer_loan()
    {
        $customerLoan = CustomerLoan::factory()->create();
        $editedCustomerLoan = CustomerLoan::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/customer_loans/'.$customerLoan->id,
            $editedCustomerLoan
        );

        $this->assertApiResponse($editedCustomerLoan);
    }

    /**
     * @test
     */
    public function test_delete_customer_loan()
    {
        $customerLoan = CustomerLoan::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/customer_loans/'.$customerLoan->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/customer_loans/'.$customerLoan->id
        );

        $this->response->assertStatus(404);
    }
}
