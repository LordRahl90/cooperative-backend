<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CustomerAddress;

class CustomerAddressApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_customer_address()
    {
        $customerAddress = CustomerAddress::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/customer_addresses', $customerAddress
        );

        $this->assertApiResponse($customerAddress);
    }

    /**
     * @test
     */
    public function test_read_customer_address()
    {
        $customerAddress = CustomerAddress::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/customer_addresses/'.$customerAddress->id
        );

        $this->assertApiResponse($customerAddress->toArray());
    }

    /**
     * @test
     */
    public function test_update_customer_address()
    {
        $customerAddress = CustomerAddress::factory()->create();
        $editedCustomerAddress = CustomerAddress::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/customer_addresses/'.$customerAddress->id,
            $editedCustomerAddress
        );

        $this->assertApiResponse($editedCustomerAddress);
    }

    /**
     * @test
     */
    public function test_delete_customer_address()
    {
        $customerAddress = CustomerAddress::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/customer_addresses/'.$customerAddress->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/customer_addresses/'.$customerAddress->id
        );

        $this->response->assertStatus(404);
    }
}
