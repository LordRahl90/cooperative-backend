<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CustomerNextOfKin;

class CustomerNextOfKinApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_customer_next_of_kin()
    {
        $customerNextOfKin = CustomerNextOfKin::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/customer_next_of_kins', $customerNextOfKin
        );

        $this->assertApiResponse($customerNextOfKin);
    }

    /**
     * @test
     */
    public function test_read_customer_next_of_kin()
    {
        $customerNextOfKin = CustomerNextOfKin::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/customer_next_of_kins/'.$customerNextOfKin->id
        );

        $this->assertApiResponse($customerNextOfKin->toArray());
    }

    /**
     * @test
     */
    public function test_update_customer_next_of_kin()
    {
        $customerNextOfKin = CustomerNextOfKin::factory()->create();
        $editedCustomerNextOfKin = CustomerNextOfKin::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/customer_next_of_kins/'.$customerNextOfKin->id,
            $editedCustomerNextOfKin
        );

        $this->assertApiResponse($editedCustomerNextOfKin);
    }

    /**
     * @test
     */
    public function test_delete_customer_next_of_kin()
    {
        $customerNextOfKin = CustomerNextOfKin::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/customer_next_of_kins/'.$customerNextOfKin->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/customer_next_of_kins/'.$customerNextOfKin->id
        );

        $this->response->assertStatus(404);
    }
}
