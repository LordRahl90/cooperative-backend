<?php namespace Tests\Repositories;

use App\Models\LoanRepayment;
use App\Repositories\LoanRepaymentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class LoanRepaymentRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var LoanRepaymentRepository
     */
    protected $loanRepaymentRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->loanRepaymentRepo = \App::make(LoanRepaymentRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_loan_repayment()
    {
        $loanRepayment = LoanRepayment::factory()->make()->toArray();

        $createdLoanRepayment = $this->loanRepaymentRepo->create($loanRepayment);

        $createdLoanRepayment = $createdLoanRepayment->toArray();
        $this->assertArrayHasKey('id', $createdLoanRepayment);
        $this->assertNotNull($createdLoanRepayment['id'], 'Created LoanRepayment must have id specified');
        $this->assertNotNull(LoanRepayment::find($createdLoanRepayment['id']), 'LoanRepayment with given id must be in DB');
        $this->assertModelData($loanRepayment, $createdLoanRepayment);
    }

    /**
     * @test read
     */
    public function test_read_loan_repayment()
    {
        $loanRepayment = LoanRepayment::factory()->create();

        $dbLoanRepayment = $this->loanRepaymentRepo->find($loanRepayment->id);

        $dbLoanRepayment = $dbLoanRepayment->toArray();
        $this->assertModelData($loanRepayment->toArray(), $dbLoanRepayment);
    }

    /**
     * @test update
     */
    public function test_update_loan_repayment()
    {
        $loanRepayment = LoanRepayment::factory()->create();
        $fakeLoanRepayment = LoanRepayment::factory()->make()->toArray();

        $updatedLoanRepayment = $this->loanRepaymentRepo->update($fakeLoanRepayment, $loanRepayment->id);

        $this->assertModelData($fakeLoanRepayment, $updatedLoanRepayment->toArray());
        $dbLoanRepayment = $this->loanRepaymentRepo->find($loanRepayment->id);
        $this->assertModelData($fakeLoanRepayment, $dbLoanRepayment->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_loan_repayment()
    {
        $loanRepayment = LoanRepayment::factory()->create();

        $resp = $this->loanRepaymentRepo->delete($loanRepayment->id);

        $this->assertTrue($resp);
        $this->assertNull(LoanRepayment::find($loanRepayment->id), 'LoanRepayment should not exist in DB');
    }
}
