<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CustomerSaving;

class CustomerSavingApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_customer_saving()
    {
        $customerSaving = CustomerSaving::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/customer_savings', $customerSaving
        );

        $this->assertApiResponse($customerSaving);
    }

    /**
     * @test
     */
    public function test_read_customer_saving()
    {
        $customerSaving = CustomerSaving::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/customer_savings/'.$customerSaving->id
        );

        $this->assertApiResponse($customerSaving->toArray());
    }

    /**
     * @test
     */
    public function test_update_customer_saving()
    {
        $customerSaving = CustomerSaving::factory()->create();
        $editedCustomerSaving = CustomerSaving::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/customer_savings/'.$customerSaving->id,
            $editedCustomerSaving
        );

        $this->assertApiResponse($editedCustomerSaving);
    }

    /**
     * @test
     */
    public function test_delete_customer_saving()
    {
        $customerSaving = CustomerSaving::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/customer_savings/'.$customerSaving->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/customer_savings/'.$customerSaving->id
        );

        $this->response->assertStatus(404);
    }
}
