<?php namespace Tests\Repositories;

use App\Models\CustomerAddress;
use App\Repositories\CustomerAddressRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CustomerAddressRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CustomerAddressRepository
     */
    protected $customerAddressRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->customerAddressRepo = \App::make(CustomerAddressRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_customer_address()
    {
        $customerAddress = CustomerAddress::factory()->make()->toArray();

        $createdCustomerAddress = $this->customerAddressRepo->create($customerAddress);

        $createdCustomerAddress = $createdCustomerAddress->toArray();
        $this->assertArrayHasKey('id', $createdCustomerAddress);
        $this->assertNotNull($createdCustomerAddress['id'], 'Created CustomerAddress must have id specified');
        $this->assertNotNull(CustomerAddress::find($createdCustomerAddress['id']), 'CustomerAddress with given id must be in DB');
        $this->assertModelData($customerAddress, $createdCustomerAddress);
    }

    /**
     * @test read
     */
    public function test_read_customer_address()
    {
        $customerAddress = CustomerAddress::factory()->create();

        $dbCustomerAddress = $this->customerAddressRepo->find($customerAddress->id);

        $dbCustomerAddress = $dbCustomerAddress->toArray();
        $this->assertModelData($customerAddress->toArray(), $dbCustomerAddress);
    }

    /**
     * @test update
     */
    public function test_update_customer_address()
    {
        $customerAddress = CustomerAddress::factory()->create();
        $fakeCustomerAddress = CustomerAddress::factory()->make()->toArray();

        $updatedCustomerAddress = $this->customerAddressRepo->update($fakeCustomerAddress, $customerAddress->id);

        $this->assertModelData($fakeCustomerAddress, $updatedCustomerAddress->toArray());
        $dbCustomerAddress = $this->customerAddressRepo->find($customerAddress->id);
        $this->assertModelData($fakeCustomerAddress, $dbCustomerAddress->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_customer_address()
    {
        $customerAddress = CustomerAddress::factory()->create();

        $resp = $this->customerAddressRepo->delete($customerAddress->id);

        $this->assertTrue($resp);
        $this->assertNull(CustomerAddress::find($customerAddress->id), 'CustomerAddress should not exist in DB');
    }
}
