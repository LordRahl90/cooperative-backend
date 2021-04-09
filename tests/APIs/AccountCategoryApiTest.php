<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\AccountCategory;

class AccountCategoryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_account_category()
    {
        $accountCategory = AccountCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/account_categories', $accountCategory
        );

        $this->assertApiResponse($accountCategory);
    }

    /**
     * @test
     */
    public function test_read_account_category()
    {
        $accountCategory = AccountCategory::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/account_categories/'.$accountCategory->id
        );

        $this->assertApiResponse($accountCategory->toArray());
    }

    /**
     * @test
     */
    public function test_update_account_category()
    {
        $accountCategory = AccountCategory::factory()->create();
        $editedAccountCategory = AccountCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/account_categories/'.$accountCategory->id,
            $editedAccountCategory
        );

        $this->assertApiResponse($editedAccountCategory);
    }

    /**
     * @test
     */
    public function test_delete_account_category()
    {
        $accountCategory = AccountCategory::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/account_categories/'.$accountCategory->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/account_categories/'.$accountCategory->id
        );

        $this->response->assertStatus(404);
    }
}
