<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\SavingsAccount;

class SavingsAccountApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_savings_account()
    {
        $savingsAccount = SavingsAccount::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/savings_accounts', $savingsAccount
        );

        $this->assertApiResponse($savingsAccount);
    }

    /**
     * @test
     */
    public function test_read_savings_account()
    {
        $savingsAccount = SavingsAccount::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/savings_accounts/'.$savingsAccount->id
        );

        $this->assertApiResponse($savingsAccount->toArray());
    }

    /**
     * @test
     */
    public function test_update_savings_account()
    {
        $savingsAccount = SavingsAccount::factory()->create();
        $editedSavingsAccount = SavingsAccount::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/savings_accounts/'.$savingsAccount->id,
            $editedSavingsAccount
        );

        $this->assertApiResponse($editedSavingsAccount);
    }

    /**
     * @test
     */
    public function test_delete_savings_account()
    {
        $savingsAccount = SavingsAccount::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/savings_accounts/'.$savingsAccount->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/savings_accounts/'.$savingsAccount->id
        );

        $this->response->assertStatus(404);
    }
}
