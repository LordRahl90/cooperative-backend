<?php namespace Tests\Repositories;

use App\Models\SavingsCategory;
use App\Repositories\SavingsCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SavingsCategoryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SavingsCategoryRepository
     */
    protected $savingsCategoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->savingsCategoryRepo = \App::make(SavingsCategoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_savings_category()
    {
        $savingsCategory = SavingsCategory::factory()->make()->toArray();

        $createdSavingsCategory = $this->savingsCategoryRepo->create($savingsCategory);

        $createdSavingsCategory = $createdSavingsCategory->toArray();
        $this->assertArrayHasKey('id', $createdSavingsCategory);
        $this->assertNotNull($createdSavingsCategory['id'], 'Created SavingsCategory must have id specified');
        $this->assertNotNull(SavingsCategory::find($createdSavingsCategory['id']), 'SavingsCategory with given id must be in DB');
        $this->assertModelData($savingsCategory, $createdSavingsCategory);
    }

    /**
     * @test read
     */
    public function test_read_savings_category()
    {
        $savingsCategory = SavingsCategory::factory()->create();

        $dbSavingsCategory = $this->savingsCategoryRepo->find($savingsCategory->id);

        $dbSavingsCategory = $dbSavingsCategory->toArray();
        $this->assertModelData($savingsCategory->toArray(), $dbSavingsCategory);
    }

    /**
     * @test update
     */
    public function test_update_savings_category()
    {
        $savingsCategory = SavingsCategory::factory()->create();
        $fakeSavingsCategory = SavingsCategory::factory()->make()->toArray();

        $updatedSavingsCategory = $this->savingsCategoryRepo->update($fakeSavingsCategory, $savingsCategory->id);

        $this->assertModelData($fakeSavingsCategory, $updatedSavingsCategory->toArray());
        $dbSavingsCategory = $this->savingsCategoryRepo->find($savingsCategory->id);
        $this->assertModelData($fakeSavingsCategory, $dbSavingsCategory->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_savings_category()
    {
        $savingsCategory = SavingsCategory::factory()->create();

        $resp = $this->savingsCategoryRepo->delete($savingsCategory->id);

        $this->assertTrue($resp);
        $this->assertNull(SavingsCategory::find($savingsCategory->id), 'SavingsCategory should not exist in DB');
    }
}
