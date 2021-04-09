<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CustomerTransaction;

class CustomerTransactionApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_customer_transaction()
    {
        $customerTransaction = CustomerTransaction::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/customer_transactions', $customerTransaction
        );

        $this->assertApiResponse($customerTransaction);
    }

    /**
     * @test
     */
    public function test_read_customer_transaction()
    {
        $customerTransaction = CustomerTransaction::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/customer_transactions/'.$customerTransaction->id
        );

        $this->assertApiResponse($customerTransaction->toArray());
    }

    /**
     * @test
     */
    public function test_update_customer_transaction()
    {
        $customerTransaction = CustomerTransaction::factory()->create();
        $editedCustomerTransaction = CustomerTransaction::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/customer_transactions/'.$customerTransaction->id,
            $editedCustomerTransaction
        );

        $this->assertApiResponse($editedCustomerTransaction);
    }

    /**
     * @test
     */
    public function test_delete_customer_transaction()
    {
        $customerTransaction = CustomerTransaction::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/customer_transactions/'.$customerTransaction->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/customer_transactions/'.$customerTransaction->id
        );

        $this->response->assertStatus(404);
    }
}
