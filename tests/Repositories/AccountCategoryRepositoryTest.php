<?php namespace Tests\Repositories;

use App\Models\AccountCategory;
use App\Repositories\AccountCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AccountCategoryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AccountCategoryRepository
     */
    protected $accountCategoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->accountCategoryRepo = \App::make(AccountCategoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_account_category()
    {
        $accountCategory = AccountCategory::factory()->make()->toArray();

        $createdAccountCategory = $this->accountCategoryRepo->create($accountCategory);

        $createdAccountCategory = $createdAccountCategory->toArray();
        $this->assertArrayHasKey('id', $createdAccountCategory);
        $this->assertNotNull($createdAccountCategory['id'], 'Created AccountCategory must have id specified');
        $this->assertNotNull(AccountCategory::find($createdAccountCategory['id']), 'AccountCategory with given id must be in DB');
        $this->assertModelData($accountCategory, $createdAccountCategory);
    }

    /**
     * @test read
     */
    public function test_read_account_category()
    {
        $accountCategory = AccountCategory::factory()->create();

        $dbAccountCategory = $this->accountCategoryRepo->find($accountCategory->id);

        $dbAccountCategory = $dbAccountCategory->toArray();
        $this->assertModelData($accountCategory->toArray(), $dbAccountCategory);
    }

    /**
     * @test update
     */
    public function test_update_account_category()
    {
        $accountCategory = AccountCategory::factory()->create();
        $fakeAccountCategory = AccountCategory::factory()->make()->toArray();

        $updatedAccountCategory = $this->accountCategoryRepo->update($fakeAccountCategory, $accountCategory->id);

        $this->assertModelData($fakeAccountCategory, $updatedAccountCategory->toArray());
        $dbAccountCategory = $this->accountCategoryRepo->find($accountCategory->id);
        $this->assertModelData($fakeAccountCategory, $dbAccountCategory->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_account_category()
    {
        $accountCategory = AccountCategory::factory()->create();

        $resp = $this->accountCategoryRepo->delete($accountCategory->id);

        $this->assertTrue($resp);
        $this->assertNull(AccountCategory::find($accountCategory->id), 'AccountCategory should not exist in DB');
    }
}
