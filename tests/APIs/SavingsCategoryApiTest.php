<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\SavingsCategory;

class SavingsCategoryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_savings_category()
    {
        $savingsCategory = SavingsCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/savings_categories', $savingsCategory
        );

        $this->assertApiResponse($savingsCategory);
    }

    /**
     * @test
     */
    public function test_read_savings_category()
    {
        $savingsCategory = SavingsCategory::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/savings_categories/'.$savingsCategory->id
        );

        $this->assertApiResponse($savingsCategory->toArray());
    }

    /**
     * @test
     */
    public function test_update_savings_category()
    {
        $savingsCategory = SavingsCategory::factory()->create();
        $editedSavingsCategory = SavingsCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/savings_categories/'.$savingsCategory->id,
            $editedSavingsCategory
        );

        $this->assertApiResponse($editedSavingsCategory);
    }

    /**
     * @test
     */
    public function test_delete_savings_category()
    {
        $savingsCategory = SavingsCategory::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/savings_categories/'.$savingsCategory->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/savings_categories/'.$savingsCategory->id
        );

        $this->response->assertStatus(404);
    }
}
