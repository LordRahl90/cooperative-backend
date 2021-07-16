<?php namespace Tests\Repositories;

use App\Models\FeeManagement;
use App\Repositories\FeeManagementRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class FeeManagementRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var FeeManagementRepository
     */
    protected $feeManagementRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->feeManagementRepo = \App::make(FeeManagementRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_fee_management()
    {
        $feeManagement = FeeManagement::factory()->make()->toArray();

        $createdFeeManagement = $this->feeManagementRepo->create($feeManagement);

        $createdFeeManagement = $createdFeeManagement->toArray();
        $this->assertArrayHasKey('id', $createdFeeManagement);
        $this->assertNotNull($createdFeeManagement['id'], 'Created FeeManagement must have id specified');
        $this->assertNotNull(FeeManagement::find($createdFeeManagement['id']), 'FeeManagement with given id must be in DB');
        $this->assertModelData($feeManagement, $createdFeeManagement);
    }

    /**
     * @test read
     */
    public function test_read_fee_management()
    {
        $feeManagement = FeeManagement::factory()->create();

        $dbFeeManagement = $this->feeManagementRepo->find($feeManagement->id);

        $dbFeeManagement = $dbFeeManagement->toArray();
        $this->assertModelData($feeManagement->toArray(), $dbFeeManagement);
    }

    /**
     * @test update
     */
    public function test_update_fee_management()
    {
        $feeManagement = FeeManagement::factory()->create();
        $fakeFeeManagement = FeeManagement::factory()->make()->toArray();

        $updatedFeeManagement = $this->feeManagementRepo->update($fakeFeeManagement, $feeManagement->id);

        $this->assertModelData($fakeFeeManagement, $updatedFeeManagement->toArray());
        $dbFeeManagement = $this->feeManagementRepo->find($feeManagement->id);
        $this->assertModelData($fakeFeeManagement, $dbFeeManagement->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_fee_management()
    {
        $feeManagement = FeeManagement::factory()->create();

        $resp = $this->feeManagementRepo->delete($feeManagement->id);

        $this->assertTrue($resp);
        $this->assertNull(FeeManagement::find($feeManagement->id), 'FeeManagement should not exist in DB');
    }
}
