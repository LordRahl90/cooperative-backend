<?php namespace Tests\Repositories;

use App\Models\AccountHead;
use App\Repositories\AccountHeadRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AccountHeadRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AccountHeadRepository
     */
    protected $accountHeadRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->accountHeadRepo = \App::make(AccountHeadRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_account_head()
    {
        $accountHead = AccountHead::factory()->make()->toArray();

        $createdAccountHead = $this->accountHeadRepo->create($accountHead);

        $createdAccountHead = $createdAccountHead->toArray();
        $this->assertArrayHasKey('id', $createdAccountHead);
        $this->assertNotNull($createdAccountHead['id'], 'Created AccountHead must have id specified');
        $this->assertNotNull(AccountHead::find($createdAccountHead['id']), 'AccountHead with given id must be in DB');
        $this->assertModelData($accountHead, $createdAccountHead);
    }

    /**
     * @test read
     */
    public function test_read_account_head()
    {
        $accountHead = AccountHead::factory()->create();

        $dbAccountHead = $this->accountHeadRepo->find($accountHead->id);

        $dbAccountHead = $dbAccountHead->toArray();
        $this->assertModelData($accountHead->toArray(), $dbAccountHead);
    }

    /**
     * @test update
     */
    public function test_update_account_head()
    {
        $accountHead = AccountHead::factory()->create();
        $fakeAccountHead = AccountHead::factory()->make()->toArray();

        $updatedAccountHead = $this->accountHeadRepo->update($fakeAccountHead, $accountHead->id);

        $this->assertModelData($fakeAccountHead, $updatedAccountHead->toArray());
        $dbAccountHead = $this->accountHeadRepo->find($accountHead->id);
        $this->assertModelData($fakeAccountHead, $dbAccountHead->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_account_head()
    {
        $accountHead = AccountHead::factory()->create();

        $resp = $this->accountHeadRepo->delete($accountHead->id);

        $this->assertTrue($resp);
        $this->assertNull(AccountHead::find($accountHead->id), 'AccountHead should not exist in DB');
    }
}
