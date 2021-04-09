<?php namespace Tests\Repositories;

use App\Models\CustomerLoanLog;
use App\Repositories\CustomerLoanLogRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CustomerLoanLogRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CustomerLoanLogRepository
     */
    protected $customerLoanLogRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->customerLoanLogRepo = \App::make(CustomerLoanLogRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_customer_loan_log()
    {
        $customerLoanLog = CustomerLoanLog::factory()->make()->toArray();

        $createdCustomerLoanLog = $this->customerLoanLogRepo->create($customerLoanLog);

        $createdCustomerLoanLog = $createdCustomerLoanLog->toArray();
        $this->assertArrayHasKey('id', $createdCustomerLoanLog);
        $this->assertNotNull($createdCustomerLoanLog['id'], 'Created CustomerLoanLog must have id specified');
        $this->assertNotNull(CustomerLoanLog::find($createdCustomerLoanLog['id']), 'CustomerLoanLog with given id must be in DB');
        $this->assertModelData($customerLoanLog, $createdCustomerLoanLog);
    }

    /**
     * @test read
     */
    public function test_read_customer_loan_log()
    {
        $customerLoanLog = CustomerLoanLog::factory()->create();

        $dbCustomerLoanLog = $this->customerLoanLogRepo->find($customerLoanLog->id);

        $dbCustomerLoanLog = $dbCustomerLoanLog->toArray();
        $this->assertModelData($customerLoanLog->toArray(), $dbCustomerLoanLog);
    }

    /**
     * @test update
     */
    public function test_update_customer_loan_log()
    {
        $customerLoanLog = CustomerLoanLog::factory()->create();
        $fakeCustomerLoanLog = CustomerLoanLog::factory()->make()->toArray();

        $updatedCustomerLoanLog = $this->customerLoanLogRepo->update($fakeCustomerLoanLog, $customerLoanLog->id);

        $this->assertModelData($fakeCustomerLoanLog, $updatedCustomerLoanLog->toArray());
        $dbCustomerLoanLog = $this->customerLoanLogRepo->find($customerLoanLog->id);
        $this->assertModelData($fakeCustomerLoanLog, $dbCustomerLoanLog->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_customer_loan_log()
    {
        $customerLoanLog = CustomerLoanLog::factory()->create();

        $resp = $this->customerLoanLogRepo->delete($customerLoanLog->id);

        $this->assertTrue($resp);
        $this->assertNull(CustomerLoanLog::find($customerLoanLog->id), 'CustomerLoanLog should not exist in DB');
    }
}
