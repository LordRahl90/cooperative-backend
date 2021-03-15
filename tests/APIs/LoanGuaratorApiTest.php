<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\LoanGuarator;

class LoanGuaratorApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_loan_guarator()
    {
        $loanGuarator = LoanGuarator::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/loan_guarators', $loanGuarator
        );

        $this->assertApiResponse($loanGuarator);
    }

    /**
     * @test
     */
    public function test_read_loan_guarator()
    {
        $loanGuarator = LoanGuarator::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/loan_guarators/'.$loanGuarator->id
        );

        $this->assertApiResponse($loanGuarator->toArray());
    }

    /**
     * @test
     */
    public function test_update_loan_guarator()
    {
        $loanGuarator = LoanGuarator::factory()->create();
        $editedLoanGuarator = LoanGuarator::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/loan_guarators/'.$loanGuarator->id,
            $editedLoanGuarator
        );

        $this->assertApiResponse($editedLoanGuarator);
    }

    /**
     * @test
     */
    public function test_delete_loan_guarator()
    {
        $loanGuarator = LoanGuarator::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/loan_guarators/'.$loanGuarator->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/loan_guarators/'.$loanGuarator->id
        );

        $this->response->assertStatus(404);
    }
}
