<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\AccountHead;

class AccountHeadApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_account_head()
    {
        $accountHead = AccountHead::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/account_heads', $accountHead
        );

        $this->assertApiResponse($accountHead);
    }

    /**
     * @test
     */
    public function test_read_account_head()
    {
        $accountHead = AccountHead::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/account_heads/'.$accountHead->id
        );

        $this->assertApiResponse($accountHead->toArray());
    }

    /**
     * @test
     */
    public function test_update_account_head()
    {
        $accountHead = AccountHead::factory()->create();
        $editedAccountHead = AccountHead::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/account_heads/'.$accountHead->id,
            $editedAccountHead
        );

        $this->assertApiResponse($editedAccountHead);
    }

    /**
     * @test
     */
    public function test_delete_account_head()
    {
        $accountHead = AccountHead::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/account_heads/'.$accountHead->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/account_heads/'.$accountHead->id
        );

        $this->response->assertStatus(404);
    }
}
