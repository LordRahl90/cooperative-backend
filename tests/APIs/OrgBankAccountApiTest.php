<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\OrgBankAccount;

class OrgBankAccountApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_org_bank_account()
    {
        $orgBankAccount = OrgBankAccount::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/org_bank_accounts', $orgBankAccount
        );

        $this->assertApiResponse($orgBankAccount);
    }

    /**
     * @test
     */
    public function test_read_org_bank_account()
    {
        $orgBankAccount = OrgBankAccount::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/org_bank_accounts/'.$orgBankAccount->id
        );

        $this->assertApiResponse($orgBankAccount->toArray());
    }

    /**
     * @test
     */
    public function test_update_org_bank_account()
    {
        $orgBankAccount = OrgBankAccount::factory()->create();
        $editedOrgBankAccount = OrgBankAccount::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/org_bank_accounts/'.$orgBankAccount->id,
            $editedOrgBankAccount
        );

        $this->assertApiResponse($editedOrgBankAccount);
    }

    /**
     * @test
     */
    public function test_delete_org_bank_account()
    {
        $orgBankAccount = OrgBankAccount::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/org_bank_accounts/'.$orgBankAccount->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/org_bank_accounts/'.$orgBankAccount->id
        );

        $this->response->assertStatus(404);
    }
}
