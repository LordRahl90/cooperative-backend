<?php namespace Tests\Repositories;

use App\Models\Staff;
use App\Repositories\StaffRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class StaffRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var StaffRepository
     */
    protected $staffRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->staffRepo = \App::make(StaffRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_staff()
    {
        $staff = Staff::factory()->make()->toArray();

        $createdStaff = $this->staffRepo->create($staff);

        $createdStaff = $createdStaff->toArray();
        $this->assertArrayHasKey('id', $createdStaff);
        $this->assertNotNull($createdStaff['id'], 'Created Staff must have id specified');
        $this->assertNotNull(Staff::find($createdStaff['id']), 'Staff with given id must be in DB');
        $this->assertModelData($staff, $createdStaff);
    }

    /**
     * @test read
     */
    public function test_read_staff()
    {
        $staff = Staff::factory()->create();

        $dbStaff = $this->staffRepo->find($staff->id);

        $dbStaff = $dbStaff->toArray();
        $this->assertModelData($staff->toArray(), $dbStaff);
    }

    /**
     * @test update
     */
    public function test_update_staff()
    {
        $staff = Staff::factory()->create();
        $fakeStaff = Staff::factory()->make()->toArray();

        $updatedStaff = $this->staffRepo->update($fakeStaff, $staff->id);

        $this->assertModelData($fakeStaff, $updatedStaff->toArray());
        $dbStaff = $this->staffRepo->find($staff->id);
        $this->assertModelData($fakeStaff, $dbStaff->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_staff()
    {
        $staff = Staff::factory()->create();

        $resp = $this->staffRepo->delete($staff->id);

        $this->assertTrue($resp);
        $this->assertNull(Staff::find($staff->id), 'Staff should not exist in DB');
    }
}
