<?php namespace Tests\Repositories;

use App\Models\LoanGuarator;
use App\Repositories\LoanGuaratorRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class LoanGuaratorRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var LoanGuaratorRepository
     */
    protected $loanGuaratorRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->loanGuaratorRepo = \App::make(LoanGuaratorRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_loan_guarator()
    {
        $loanGuarator = LoanGuarator::factory()->make()->toArray();

        $createdLoanGuarator = $this->loanGuaratorRepo->create($loanGuarator);

        $createdLoanGuarator = $createdLoanGuarator->toArray();
        $this->assertArrayHasKey('id', $createdLoanGuarator);
        $this->assertNotNull($createdLoanGuarator['id'], 'Created LoanGuarator must have id specified');
        $this->assertNotNull(LoanGuarator::find($createdLoanGuarator['id']), 'LoanGuarator with given id must be in DB');
        $this->assertModelData($loanGuarator, $createdLoanGuarator);
    }

    /**
     * @test read
     */
    public function test_read_loan_guarator()
    {
        $loanGuarator = LoanGuarator::factory()->create();

        $dbLoanGuarator = $this->loanGuaratorRepo->find($loanGuarator->id);

        $dbLoanGuarator = $dbLoanGuarator->toArray();
        $this->assertModelData($loanGuarator->toArray(), $dbLoanGuarator);
    }

    /**
     * @test update
     */
    public function test_update_loan_guarator()
    {
        $loanGuarator = LoanGuarator::factory()->create();
        $fakeLoanGuarator = LoanGuarator::factory()->make()->toArray();

        $updatedLoanGuarator = $this->loanGuaratorRepo->update($fakeLoanGuarator, $loanGuarator->id);

        $this->assertModelData($fakeLoanGuarator, $updatedLoanGuarator->toArray());
        $dbLoanGuarator = $this->loanGuaratorRepo->find($loanGuarator->id);
        $this->assertModelData($fakeLoanGuarator, $dbLoanGuarator->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_loan_guarator()
    {
        $loanGuarator = LoanGuarator::factory()->create();

        $resp = $this->loanGuaratorRepo->delete($loanGuarator->id);

        $this->assertTrue($resp);
        $this->assertNull(LoanGuarator::find($loanGuarator->id), 'LoanGuarator should not exist in DB');
    }
}
