<?php namespace Tests\Repositories;

use App\Models\CustomerTransaction;
use App\Repositories\CustomerTransactionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CustomerTransactionRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CustomerTransactionRepository
     */
    protected $customerTransactionRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->customerTransactionRepo = \App::make(CustomerTransactionRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_customer_transaction()
    {
        $customerTransaction = CustomerTransaction::factory()->make()->toArray();

        $createdCustomerTransaction = $this->customerTransactionRepo->create($customerTransaction);

        $createdCustomerTransaction = $createdCustomerTransaction->toArray();
        $this->assertArrayHasKey('id', $createdCustomerTransaction);
        $this->assertNotNull($createdCustomerTransaction['id'], 'Created CustomerTransaction must have id specified');
        $this->assertNotNull(CustomerTransaction::find($createdCustomerTransaction['id']), 'CustomerTransaction with given id must be in DB');
        $this->assertModelData($customerTransaction, $createdCustomerTransaction);
    }

    /**
     * @test read
     */
    public function test_read_customer_transaction()
    {
        $customerTransaction = CustomerTransaction::factory()->create();

        $dbCustomerTransaction = $this->customerTransactionRepo->find($customerTransaction->id);

        $dbCustomerTransaction = $dbCustomerTransaction->toArray();
        $this->assertModelData($customerTransaction->toArray(), $dbCustomerTransaction);
    }

    /**
     * @test update
     */
    public function test_update_customer_transaction()
    {
        $customerTransaction = CustomerTransaction::factory()->create();
        $fakeCustomerTransaction = CustomerTransaction::factory()->make()->toArray();

        $updatedCustomerTransaction = $this->customerTransactionRepo->update($fakeCustomerTransaction, $customerTransaction->id);

        $this->assertModelData($fakeCustomerTransaction, $updatedCustomerTransaction->toArray());
        $dbCustomerTransaction = $this->customerTransactionRepo->find($customerTransaction->id);
        $this->assertModelData($fakeCustomerTransaction, $dbCustomerTransaction->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_customer_transaction()
    {
        $customerTransaction = CustomerTransaction::factory()->create();

        $resp = $this->customerTransactionRepo->delete($customerTransaction->id);

        $this->assertTrue($resp);
        $this->assertNull(CustomerTransaction::find($customerTransaction->id), 'CustomerTransaction should not exist in DB');
    }
}
