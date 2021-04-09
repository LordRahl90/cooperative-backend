<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CustomerBankAccount;

class CustomerBankAccountApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_customer_bank_account()
    {
        $customerBankAccount = CustomerBankAccount::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/customer_bank_accounts', $customerBankAccount
        );

        $this->assertApiResponse($customerBankAccount);
    }

    /**
     * @test
     */
    public function test_read_customer_bank_account()
    {
        $customerBankAccount = CustomerBankAccount::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/customer_bank_accounts/'.$customerBankAccount->id
        );

        $this->assertApiResponse($customerBankAccount->toArray());
    }

    /**
     * @test
     */
    public function test_update_customer_bank_account()
    {
        $customerBankAccount = CustomerBankAccount::factory()->create();
        $editedCustomerBankAccount = CustomerBankAccount::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/customer_bank_accounts/'.$customerBankAccount->id,
            $editedCustomerBankAccount
        );

        $this->assertApiResponse($editedCustomerBankAccount);
    }

    /**
     * @test
     */
    public function test_delete_customer_bank_account()
    {
        $customerBankAccount = CustomerBankAccount::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/customer_bank_accounts/'.$customerBankAccount->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/customer_bank_accounts/'.$customerBankAccount->id
        );

        $this->response->assertStatus(404);
    }
}
