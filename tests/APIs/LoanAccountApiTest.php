<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\LoanAccount;

class LoanAccountApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_loan_account()
    {
        $loanAccount = LoanAccount::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/loan_accounts', $loanAccount
        );

        $this->assertApiResponse($loanAccount);
    }

    /**
     * @test
     */
    public function test_read_loan_account()
    {
        $loanAccount = LoanAccount::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/loan_accounts/'.$loanAccount->id
        );

        $this->assertApiResponse($loanAccount->toArray());
    }

    /**
     * @test
     */
    public function test_update_loan_account()
    {
        $loanAccount = LoanAccount::factory()->create();
        $editedLoanAccount = LoanAccount::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/loan_accounts/'.$loanAccount->id,
            $editedLoanAccount
        );

        $this->assertApiResponse($editedLoanAccount);
    }

    /**
     * @test
     */
    public function test_delete_loan_account()
    {
        $loanAccount = LoanAccount::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/loan_accounts/'.$loanAccount->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/loan_accounts/'.$loanAccount->id
        );

        $this->response->assertStatus(404);
    }
}
