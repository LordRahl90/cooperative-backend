<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\LoanCategory;

class LoanCategoryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_loan_category()
    {
        $loanCategory = LoanCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/loan_categories', $loanCategory
        );

        $this->assertApiResponse($loanCategory);
    }

    /**
     * @test
     */
    public function test_read_loan_category()
    {
        $loanCategory = LoanCategory::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/loan_categories/'.$loanCategory->id
        );

        $this->assertApiResponse($loanCategory->toArray());
    }

    /**
     * @test
     */
    public function test_update_loan_category()
    {
        $loanCategory = LoanCategory::factory()->create();
        $editedLoanCategory = LoanCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/loan_categories/'.$loanCategory->id,
            $editedLoanCategory
        );

        $this->assertApiResponse($editedLoanCategory);
    }

    /**
     * @test
     */
    public function test_delete_loan_category()
    {
        $loanCategory = LoanCategory::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/loan_categories/'.$loanCategory->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/loan_categories/'.$loanCategory->id
        );

        $this->response->assertStatus(404);
    }
}
