<?php namespace Tests\Repositories;

use App\Models\CustomerNextOfKin;
use App\Repositories\CustomerNextOfKinRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CustomerNextOfKinRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CustomerNextOfKinRepository
     */
    protected $customerNextOfKinRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->customerNextOfKinRepo = \App::make(CustomerNextOfKinRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_customer_next_of_kin()
    {
        $customerNextOfKin = CustomerNextOfKin::factory()->make()->toArray();

        $createdCustomerNextOfKin = $this->customerNextOfKinRepo->create($customerNextOfKin);

        $createdCustomerNextOfKin = $createdCustomerNextOfKin->toArray();
        $this->assertArrayHasKey('id', $createdCustomerNextOfKin);
        $this->assertNotNull($createdCustomerNextOfKin['id'], 'Created CustomerNextOfKin must have id specified');
        $this->assertNotNull(CustomerNextOfKin::find($createdCustomerNextOfKin['id']), 'CustomerNextOfKin with given id must be in DB');
        $this->assertModelData($customerNextOfKin, $createdCustomerNextOfKin);
    }

    /**
     * @test read
     */
    public function test_read_customer_next_of_kin()
    {
        $customerNextOfKin = CustomerNextOfKin::factory()->create();

        $dbCustomerNextOfKin = $this->customerNextOfKinRepo->find($customerNextOfKin->id);

        $dbCustomerNextOfKin = $dbCustomerNextOfKin->toArray();
        $this->assertModelData($customerNextOfKin->toArray(), $dbCustomerNextOfKin);
    }

    /**
     * @test update
     */
    public function test_update_customer_next_of_kin()
    {
        $customerNextOfKin = CustomerNextOfKin::factory()->create();
        $fakeCustomerNextOfKin = CustomerNextOfKin::factory()->make()->toArray();

        $updatedCustomerNextOfKin = $this->customerNextOfKinRepo->update($fakeCustomerNextOfKin, $customerNextOfKin->id);

        $this->assertModelData($fakeCustomerNextOfKin, $updatedCustomerNextOfKin->toArray());
        $dbCustomerNextOfKin = $this->customerNextOfKinRepo->find($customerNextOfKin->id);
        $this->assertModelData($fakeCustomerNextOfKin, $dbCustomerNextOfKin->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_customer_next_of_kin()
    {
        $customerNextOfKin = CustomerNextOfKin::factory()->create();

        $resp = $this->customerNextOfKinRepo->delete($customerNextOfKin->id);

        $this->assertTrue($resp);
        $this->assertNull(CustomerNextOfKin::find($customerNextOfKin->id), 'CustomerNextOfKin should not exist in DB');
    }
}
