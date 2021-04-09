<?php namespace Tests\Repositories;

use App\Models\OrgAccountCategory;
use App\Repositories\OrgAccountCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class OrgAccountCategoryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var OrgAccountCategoryRepository
     */
    protected $orgAccountCategoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->orgAccountCategoryRepo = \App::make(OrgAccountCategoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_org_account_category()
    {
        $orgAccountCategory = OrgAccountCategory::factory()->make()->toArray();

        $createdOrgAccountCategory = $this->orgAccountCategoryRepo->create($orgAccountCategory);

        $createdOrgAccountCategory = $createdOrgAccountCategory->toArray();
        $this->assertArrayHasKey('id', $createdOrgAccountCategory);
        $this->assertNotNull($createdOrgAccountCategory['id'], 'Created OrgAccountCategory must have id specified');
        $this->assertNotNull(OrgAccountCategory::find($createdOrgAccountCategory['id']), 'OrgAccountCategory with given id must be in DB');
        $this->assertModelData($orgAccountCategory, $createdOrgAccountCategory);
    }

    /**
     * @test read
     */
    public function test_read_org_account_category()
    {
        $orgAccountCategory = OrgAccountCategory::factory()->create();

        $dbOrgAccountCategory = $this->orgAccountCategoryRepo->find($orgAccountCategory->id);

        $dbOrgAccountCategory = $dbOrgAccountCategory->toArray();
        $this->assertModelData($orgAccountCategory->toArray(), $dbOrgAccountCategory);
    }

    /**
     * @test update
     */
    public function test_update_org_account_category()
    {
        $orgAccountCategory = OrgAccountCategory::factory()->create();
        $fakeOrgAccountCategory = OrgAccountCategory::factory()->make()->toArray();

        $updatedOrgAccountCategory = $this->orgAccountCategoryRepo->update($fakeOrgAccountCategory, $orgAccountCategory->id);

        $this->assertModelData($fakeOrgAccountCategory, $updatedOrgAccountCategory->toArray());
        $dbOrgAccountCategory = $this->orgAccountCategoryRepo->find($orgAccountCategory->id);
        $this->assertModelData($fakeOrgAccountCategory, $dbOrgAccountCategory->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_org_account_category()
    {
        $orgAccountCategory = OrgAccountCategory::factory()->create();

        $resp = $this->orgAccountCategoryRepo->delete($orgAccountCategory->id);

        $this->assertTrue($resp);
        $this->assertNull(OrgAccountCategory::find($orgAccountCategory->id), 'OrgAccountCategory should not exist in DB');
    }
}
