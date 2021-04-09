<?php namespace Tests\Repositories;

use App\Models\LoanAccount;
use App\Repositories\LoanAccountRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class LoanAccountRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var LoanAccountRepository
     */
    protected $loanAccountRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->loanAccountRepo = \App::make(LoanAccountRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_loan_account()
    {
        $loanAccount = LoanAccount::factory()->make()->toArray();

        $createdLoanAccount = $this->loanAccountRepo->create($loanAccount);

        $createdLoanAccount = $createdLoanAccount->toArray();
        $this->assertArrayHasKey('id', $createdLoanAccount);
        $this->assertNotNull($createdLoanAccount['id'], 'Created LoanAccount must have id specified');
        $this->assertNotNull(LoanAccount::find($createdLoanAccount['id']), 'LoanAccount with given id must be in DB');
        $this->assertModelData($loanAccount, $createdLoanAccount);
    }

    /**
     * @test read
     */
    public function test_read_loan_account()
    {
        $loanAccount = LoanAccount::factory()->create();

        $dbLoanAccount = $this->loanAccountRepo->find($loanAccount->id);

        $dbLoanAccount = $dbLoanAccount->toArray();
        $this->assertModelData($loanAccount->toArray(), $dbLoanAccount);
    }

    /**
     * @test update
     */
    public function test_update_loan_account()
    {
        $loanAccount = LoanAccount::factory()->create();
        $fakeLoanAccount = LoanAccount::factory()->make()->toArray();

        $updatedLoanAccount = $this->loanAccountRepo->update($fakeLoanAccount, $loanAccount->id);

        $this->assertModelData($fakeLoanAccount, $updatedLoanAccount->toArray());
        $dbLoanAccount = $this->loanAccountRepo->find($loanAccount->id);
        $this->assertModelData($fakeLoanAccount, $dbLoanAccount->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_loan_account()
    {
        $loanAccount = LoanAccount::factory()->create();

        $resp = $this->loanAccountRepo->delete($loanAccount->id);

        $this->assertTrue($resp);
        $this->assertNull(LoanAccount::find($loanAccount->id), 'LoanAccount should not exist in DB');
    }
}
