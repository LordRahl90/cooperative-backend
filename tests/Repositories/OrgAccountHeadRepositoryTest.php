<?php namespace Tests\Repositories;

use App\Models\OrgAccountHead;
use App\Repositories\OrgAccountHeadRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class OrgAccountHeadRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var OrgAccountHeadRepository
     */
    protected $orgAccountHeadRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->orgAccountHeadRepo = \App::make(OrgAccountHeadRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_org_account_head()
    {
        $orgAccountHead = OrgAccountHead::factory()->make()->toArray();

        $createdOrgAccountHead = $this->orgAccountHeadRepo->create($orgAccountHead);

        $createdOrgAccountHead = $createdOrgAccountHead->toArray();
        $this->assertArrayHasKey('id', $createdOrgAccountHead);
        $this->assertNotNull($createdOrgAccountHead['id'], 'Created OrgAccountHead must have id specified');
        $this->assertNotNull(OrgAccountHead::find($createdOrgAccountHead['id']), 'OrgAccountHead with given id must be in DB');
        $this->assertModelData($orgAccountHead, $createdOrgAccountHead);
    }

    /**
     * @test read
     */
    public function test_read_org_account_head()
    {
        $orgAccountHead = OrgAccountHead::factory()->create();

        $dbOrgAccountHead = $this->orgAccountHeadRepo->find($orgAccountHead->id);

        $dbOrgAccountHead = $dbOrgAccountHead->toArray();
        $this->assertModelData($orgAccountHead->toArray(), $dbOrgAccountHead);
    }

    /**
     * @test update
     */
    public function test_update_org_account_head()
    {
        $orgAccountHead = OrgAccountHead::factory()->create();
        $fakeOrgAccountHead = OrgAccountHead::factory()->make()->toArray();

        $updatedOrgAccountHead = $this->orgAccountHeadRepo->update($fakeOrgAccountHead, $orgAccountHead->id);

        $this->assertModelData($fakeOrgAccountHead, $updatedOrgAccountHead->toArray());
        $dbOrgAccountHead = $this->orgAccountHeadRepo->find($orgAccountHead->id);
        $this->assertModelData($fakeOrgAccountHead, $dbOrgAccountHead->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_org_account_head()
    {
        $orgAccountHead = OrgAccountHead::factory()->create();

        $resp = $this->orgAccountHeadRepo->delete($orgAccountHead->id);

        $this->assertTrue($resp);
        $this->assertNull(OrgAccountHead::find($orgAccountHead->id), 'OrgAccountHead should not exist in DB');
    }
}
