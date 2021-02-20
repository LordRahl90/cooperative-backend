<?php namespace Tests\Repositories;

use App\Models\CustomerBankAccount;
use App\Repositories\CustomerBankAccountRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CustomerBankAccountRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CustomerBankAccountRepository
     */
    protected $customerBankAccountRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->customerBankAccountRepo = \App::make(CustomerBankAccountRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_customer_bank_account()
    {
        $customerBankAccount = CustomerBankAccount::factory()->make()->toArray();

        $createdCustomerBankAccount = $this->customerBankAccountRepo->create($customerBankAccount);

        $createdCustomerBankAccount = $createdCustomerBankAccount->toArray();
        $this->assertArrayHasKey('id', $createdCustomerBankAccount);
        $this->assertNotNull($createdCustomerBankAccount['id'], 'Created CustomerBankAccount must have id specified');
        $this->assertNotNull(CustomerBankAccount::find($createdCustomerBankAccount['id']), 'CustomerBankAccount with given id must be in DB');
        $this->assertModelData($customerBankAccount, $createdCustomerBankAccount);
    }

    /**
     * @test read
     */
    public function test_read_customer_bank_account()
    {
        $customerBankAccount = CustomerBankAccount::factory()->create();

        $dbCustomerBankAccount = $this->customerBankAccountRepo->find($customerBankAccount->id);

        $dbCustomerBankAccount = $dbCustomerBankAccount->toArray();
        $this->assertModelData($customerBankAccount->toArray(), $dbCustomerBankAccount);
    }

    /**
     * @test update
     */
    public function test_update_customer_bank_account()
    {
        $customerBankAccount = CustomerBankAccount::factory()->create();
        $fakeCustomerBankAccount = CustomerBankAccount::factory()->make()->toArray();

        $updatedCustomerBankAccount = $this->customerBankAccountRepo->update($fakeCustomerBankAccount, $customerBankAccount->id);

        $this->assertModelData($fakeCustomerBankAccount, $updatedCustomerBankAccount->toArray());
        $dbCustomerBankAccount = $this->customerBankAccountRepo->find($customerBankAccount->id);
        $this->assertModelData($fakeCustomerBankAccount, $dbCustomerBankAccount->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_customer_bank_account()
    {
        $customerBankAccount = CustomerBankAccount::factory()->create();

        $resp = $this->customerBankAccountRepo->delete($customerBankAccount->id);

        $this->assertTrue($resp);
        $this->assertNull(CustomerBankAccount::find($customerBankAccount->id), 'CustomerBankAccount should not exist in DB');
    }
}
