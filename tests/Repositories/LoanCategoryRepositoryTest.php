<?php namespace Tests\Repositories;

use App\Models\LoanCategory;
use App\Repositories\LoanCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class LoanCategoryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var LoanCategoryRepository
     */
    protected $loanCategoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->loanCategoryRepo = \App::make(LoanCategoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_loan_category()
    {
        $loanCategory = LoanCategory::factory()->make()->toArray();

        $createdLoanCategory = $this->loanCategoryRepo->create($loanCategory);

        $createdLoanCategory = $createdLoanCategory->toArray();
        $this->assertArrayHasKey('id', $createdLoanCategory);
        $this->assertNotNull($createdLoanCategory['id'], 'Created LoanCategory must have id specified');
        $this->assertNotNull(LoanCategory::find($createdLoanCategory['id']), 'LoanCategory with given id must be in DB');
        $this->assertModelData($loanCategory, $createdLoanCategory);
    }

    /**
     * @test read
     */
    public function test_read_loan_category()
    {
        $loanCategory = LoanCategory::factory()->create();

        $dbLoanCategory = $this->loanCategoryRepo->find($loanCategory->id);

        $dbLoanCategory = $dbLoanCategory->toArray();
        $this->assertModelData($loanCategory->toArray(), $dbLoanCategory);
    }

    /**
     * @test update
     */
    public function test_update_loan_category()
    {
        $loanCategory = LoanCategory::factory()->create();
        $fakeLoanCategory = LoanCategory::factory()->make()->toArray();

        $updatedLoanCategory = $this->loanCategoryRepo->update($fakeLoanCategory, $loanCategory->id);

        $this->assertModelData($fakeLoanCategory, $updatedLoanCategory->toArray());
        $dbLoanCategory = $this->loanCategoryRepo->find($loanCategory->id);
        $this->assertModelData($fakeLoanCategory, $dbLoanCategory->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_loan_category()
    {
        $loanCategory = LoanCategory::factory()->create();

        $resp = $this->loanCategoryRepo->delete($loanCategory->id);

        $this->assertTrue($resp);
        $this->assertNull(LoanCategory::find($loanCategory->id), 'LoanCategory should not exist in DB');
    }
}
