<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\LoanRepayment;

class LoanRepaymentApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_loan_repayment()
    {
        $loanRepayment = LoanRepayment::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/loan_repayments', $loanRepayment
        );

        $this->assertApiResponse($loanRepayment);
    }

    /**
     * @test
     */
    public function test_read_loan_repayment()
    {
        $loanRepayment = LoanRepayment::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/loan_repayments/'.$loanRepayment->id
        );

        $this->assertApiResponse($loanRepayment->toArray());
    }

    /**
     * @test
     */
    public function test_update_loan_repayment()
    {
        $loanRepayment = LoanRepayment::factory()->create();
        $editedLoanRepayment = LoanRepayment::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/loan_repayments/'.$loanRepayment->id,
            $editedLoanRepayment
        );

        $this->assertApiResponse($editedLoanRepayment);
    }

    /**
     * @test
     */
    public function test_delete_loan_repayment()
    {
        $loanRepayment = LoanRepayment::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/loan_repayments/'.$loanRepayment->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/loan_repayments/'.$loanRepayment->id
        );

        $this->response->assertStatus(404);
    }
}
