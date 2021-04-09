<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\OrgAccountHead;

class OrgAccountHeadApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_org_account_head()
    {
        $orgAccountHead = OrgAccountHead::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/org_account_heads', $orgAccountHead
        );

        $this->assertApiResponse($orgAccountHead);
    }

    /**
     * @test
     */
    public function test_read_org_account_head()
    {
        $orgAccountHead = OrgAccountHead::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/org_account_heads/'.$orgAccountHead->id
        );

        $this->assertApiResponse($orgAccountHead->toArray());
    }

    /**
     * @test
     */
    public function test_update_org_account_head()
    {
        $orgAccountHead = OrgAccountHead::factory()->create();
        $editedOrgAccountHead = OrgAccountHead::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/org_account_heads/'.$orgAccountHead->id,
            $editedOrgAccountHead
        );

        $this->assertApiResponse($editedOrgAccountHead);
    }

    /**
     * @test
     */
    public function test_delete_org_account_head()
    {
        $orgAccountHead = OrgAccountHead::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/org_account_heads/'.$orgAccountHead->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/org_account_heads/'.$orgAccountHead->id
        );

        $this->response->assertStatus(404);
    }
}
