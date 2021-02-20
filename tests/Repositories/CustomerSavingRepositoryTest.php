<?php namespace Tests\Repositories;

use App\Models\CustomerSaving;
use App\Repositories\CustomerSavingRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CustomerSavingRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CustomerSavingRepository
     */
    protected $customerSavingRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->customerSavingRepo = \App::make(CustomerSavingRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_customer_saving()
    {
        $customerSaving = CustomerSaving::factory()->make()->toArray();

        $createdCustomerSaving = $this->customerSavingRepo->create($customerSaving);

        $createdCustomerSaving = $createdCustomerSaving->toArray();
        $this->assertArrayHasKey('id', $createdCustomerSaving);
        $this->assertNotNull($createdCustomerSaving['id'], 'Created CustomerSaving must have id specified');
        $this->assertNotNull(CustomerSaving::find($createdCustomerSaving['id']), 'CustomerSaving with given id must be in DB');
        $this->assertModelData($customerSaving, $createdCustomerSaving);
    }

    /**
     * @test read
     */
    public function test_read_customer_saving()
    {
        $customerSaving = CustomerSaving::factory()->create();

        $dbCustomerSaving = $this->customerSavingRepo->find($customerSaving->id);

        $dbCustomerSaving = $dbCustomerSaving->toArray();
        $this->assertModelData($customerSaving->toArray(), $dbCustomerSaving);
    }

    /**
     * @test update
     */
    public function test_update_customer_saving()
    {
        $customerSaving = CustomerSaving::factory()->create();
        $fakeCustomerSaving = CustomerSaving::factory()->make()->toArray();

        $updatedCustomerSaving = $this->customerSavingRepo->update($fakeCustomerSaving, $customerSaving->id);

        $this->assertModelData($fakeCustomerSaving, $updatedCustomerSaving->toArray());
        $dbCustomerSaving = $this->customerSavingRepo->find($customerSaving->id);
        $this->assertModelData($fakeCustomerSaving, $dbCustomerSaving->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_customer_saving()
    {
        $customerSaving = CustomerSaving::factory()->create();

        $resp = $this->customerSavingRepo->delete($customerSaving->id);

        $this->assertTrue($resp);
        $this->assertNull(CustomerSaving::find($customerSaving->id), 'CustomerSaving should not exist in DB');
    }
}
