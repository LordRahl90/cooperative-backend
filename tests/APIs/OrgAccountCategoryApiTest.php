<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\OrgAccountCategory;

class OrgAccountCategoryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_org_account_category()
    {
        $orgAccountCategory = OrgAccountCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/org_account_categories', $orgAccountCategory
        );

        $this->assertApiResponse($orgAccountCategory);
    }

    /**
     * @test
     */
    public function test_read_org_account_category()
    {
        $orgAccountCategory = OrgAccountCategory::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/org_account_categories/'.$orgAccountCategory->id
        );

        $this->assertApiResponse($orgAccountCategory->toArray());
    }

    /**
     * @test
     */
    public function test_update_org_account_category()
    {
        $orgAccountCategory = OrgAccountCategory::factory()->create();
        $editedOrgAccountCategory = OrgAccountCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/org_account_categories/'.$orgAccountCategory->id,
            $editedOrgAccountCategory
        );

        $this->assertApiResponse($editedOrgAccountCategory);
    }

    /**
     * @test
     */
    public function test_delete_org_account_category()
    {
        $orgAccountCategory = OrgAccountCategory::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/org_account_categories/'.$orgAccountCategory->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/org_account_categories/'.$orgAccountCategory->id
        );

        $this->response->assertStatus(404);
    }
}
