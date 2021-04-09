<?php namespace Tests\Repositories;

use App\Models\OrgBankAccount;
use App\Repositories\OrgBankAccountRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class OrgBankAccountRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var OrgBankAccountRepository
     */
    protected $orgBankAccountRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->orgBankAccountRepo = \App::make(OrgBankAccountRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_org_bank_account()
    {
        $orgBankAccount = OrgBankAccount::factory()->make()->toArray();

        $createdOrgBankAccount = $this->orgBankAccountRepo->create($orgBankAccount);

        $createdOrgBankAccount = $createdOrgBankAccount->toArray();
        $this->assertArrayHasKey('id', $createdOrgBankAccount);
        $this->assertNotNull($createdOrgBankAccount['id'], 'Created OrgBankAccount must have id specified');
        $this->assertNotNull(OrgBankAccount::find($createdOrgBankAccount['id']), 'OrgBankAccount with given id must be in DB');
        $this->assertModelData($orgBankAccount, $createdOrgBankAccount);
    }

    /**
     * @test read
     */
    public function test_read_org_bank_account()
    {
        $orgBankAccount = OrgBankAccount::factory()->create();

        $dbOrgBankAccount = $this->orgBankAccountRepo->find($orgBankAccount->id);

        $dbOrgBankAccount = $dbOrgBankAccount->toArray();
        $this->assertModelData($orgBankAccount->toArray(), $dbOrgBankAccount);
    }

    /**
     * @test update
     */
    public function test_update_org_bank_account()
    {
        $orgBankAccount = OrgBankAccount::factory()->create();
        $fakeOrgBankAccount = OrgBankAccount::factory()->make()->toArray();

        $updatedOrgBankAccount = $this->orgBankAccountRepo->update($fakeOrgBankAccount, $orgBankAccount->id);

        $this->assertModelData($fakeOrgBankAccount, $updatedOrgBankAccount->toArray());
        $dbOrgBankAccount = $this->orgBankAccountRepo->find($orgBankAccount->id);
        $this->assertModelData($fakeOrgBankAccount, $dbOrgBankAccount->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_org_bank_account()
    {
        $orgBankAccount = OrgBankAccount::factory()->create();

        $resp = $this->orgBankAccountRepo->delete($orgBankAccount->id);

        $this->assertTrue($resp);
        $this->assertNull(OrgBankAccount::find($orgBankAccount->id), 'OrgBankAccount should not exist in DB');
    }
}
