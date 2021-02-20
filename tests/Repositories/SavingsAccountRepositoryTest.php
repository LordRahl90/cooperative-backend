<?php namespace Tests\Repositories;

use App\Models\SavingsAccount;
use App\Repositories\SavingsAccountRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SavingsAccountRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SavingsAccountRepository
     */
    protected $savingsAccountRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->savingsAccountRepo = \App::make(SavingsAccountRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_savings_account()
    {
        $savingsAccount = SavingsAccount::factory()->make()->toArray();

        $createdSavingsAccount = $this->savingsAccountRepo->create($savingsAccount);

        $createdSavingsAccount = $createdSavingsAccount->toArray();
        $this->assertArrayHasKey('id', $createdSavingsAccount);
        $this->assertNotNull($createdSavingsAccount['id'], 'Created SavingsAccount must have id specified');
        $this->assertNotNull(SavingsAccount::find($createdSavingsAccount['id']), 'SavingsAccount with given id must be in DB');
        $this->assertModelData($savingsAccount, $createdSavingsAccount);
    }

    /**
     * @test read
     */
    public function test_read_savings_account()
    {
        $savingsAccount = SavingsAccount::factory()->create();

        $dbSavingsAccount = $this->savingsAccountRepo->find($savingsAccount->id);

        $dbSavingsAccount = $dbSavingsAccount->toArray();
        $this->assertModelData($savingsAccount->toArray(), $dbSavingsAccount);
    }

    /**
     * @test update
     */
    public function test_update_savings_account()
    {
        $savingsAccount = SavingsAccount::factory()->create();
        $fakeSavingsAccount = SavingsAccount::factory()->make()->toArray();

        $updatedSavingsAccount = $this->savingsAccountRepo->update($fakeSavingsAccount, $savingsAccount->id);

        $this->assertModelData($fakeSavingsAccount, $updatedSavingsAccount->toArray());
        $dbSavingsAccount = $this->savingsAccountRepo->find($savingsAccount->id);
        $this->assertModelData($fakeSavingsAccount, $dbSavingsAccount->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_savings_account()
    {
        $savingsAccount = SavingsAccount::factory()->create();

        $resp = $this->savingsAccountRepo->delete($savingsAccount->id);

        $this->assertTrue($resp);
        $this->assertNull(SavingsAccount::find($savingsAccount->id), 'SavingsAccount should not exist in DB');
    }
}
