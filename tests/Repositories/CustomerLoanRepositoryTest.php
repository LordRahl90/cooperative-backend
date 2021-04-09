<?php namespace Tests\Repositories;

use App\Models\CustomerLoan;
use App\Repositories\CustomerLoanRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CustomerLoanRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CustomerLoanRepository
     */
    protected $customerLoanRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->customerLoanRepo = \App::make(CustomerLoanRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_customer_loan()
    {
        $customerLoan = CustomerLoan::factory()->make()->toArray();

        $createdCustomerLoan = $this->customerLoanRepo->create($customerLoan);

        $createdCustomerLoan = $createdCustomerLoan->toArray();
        $this->assertArrayHasKey('id', $createdCustomerLoan);
        $this->assertNotNull($createdCustomerLoan['id'], 'Created CustomerLoan must have id specified');
        $this->assertNotNull(CustomerLoan::find($createdCustomerLoan['id']), 'CustomerLoan with given id must be in DB');
        $this->assertModelData($customerLoan, $createdCustomerLoan);
    }

    /**
     * @test read
     */
    public function test_read_customer_loan()
    {
        $customerLoan = CustomerLoan::factory()->create();

        $dbCustomerLoan = $this->customerLoanRepo->find($customerLoan->id);

        $dbCustomerLoan = $dbCustomerLoan->toArray();
        $this->assertModelData($customerLoan->toArray(), $dbCustomerLoan);
    }

    /**
     * @test update
     */
    public function test_update_customer_loan()
    {
        $customerLoan = CustomerLoan::factory()->create();
        $fakeCustomerLoan = CustomerLoan::factory()->make()->toArray();

        $updatedCustomerLoan = $this->customerLoanRepo->update($fakeCustomerLoan, $customerLoan->id);

        $this->assertModelData($fakeCustomerLoan, $updatedCustomerLoan->toArray());
        $dbCustomerLoan = $this->customerLoanRepo->find($customerLoan->id);
        $this->assertModelData($fakeCustomerLoan, $dbCustomerLoan->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_customer_loan()
    {
        $customerLoan = CustomerLoan::factory()->create();

        $resp = $this->customerLoanRepo->delete($customerLoan->id);

        $this->assertTrue($resp);
        $this->assertNull(CustomerLoan::find($customerLoan->id), 'CustomerLoan should not exist in DB');
    }
}
