<?php namespace Tests\Repositories;

use App\Models\JournalVoucher;
use App\Repositories\JournalVoucherRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class JournalVoucherRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var JournalVoucherRepository
     */
    protected $journalVoucherRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->journalVoucherRepo = \App::make(JournalVoucherRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_journal_voucher()
    {
        $journalVoucher = JournalVoucher::factory()->make()->toArray();

        $createdJournalVoucher = $this->journalVoucherRepo->create($journalVoucher);

        $createdJournalVoucher = $createdJournalVoucher->toArray();
        $this->assertArrayHasKey('id', $createdJournalVoucher);
        $this->assertNotNull($createdJournalVoucher['id'], 'Created JournalVoucher must have id specified');
        $this->assertNotNull(JournalVoucher::find($createdJournalVoucher['id']), 'JournalVoucher with given id must be in DB');
        $this->assertModelData($journalVoucher, $createdJournalVoucher);
    }

    /**
     * @test read
     */
    public function test_read_journal_voucher()
    {
        $journalVoucher = JournalVoucher::factory()->create();

        $dbJournalVoucher = $this->journalVoucherRepo->find($journalVoucher->id);

        $dbJournalVoucher = $dbJournalVoucher->toArray();
        $this->assertModelData($journalVoucher->toArray(), $dbJournalVoucher);
    }

    /**
     * @test update
     */
    public function test_update_journal_voucher()
    {
        $journalVoucher = JournalVoucher::factory()->create();
        $fakeJournalVoucher = JournalVoucher::factory()->make()->toArray();

        $updatedJournalVoucher = $this->journalVoucherRepo->update($fakeJournalVoucher, $journalVoucher->id);

        $this->assertModelData($fakeJournalVoucher, $updatedJournalVoucher->toArray());
        $dbJournalVoucher = $this->journalVoucherRepo->find($journalVoucher->id);
        $this->assertModelData($fakeJournalVoucher, $dbJournalVoucher->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_journal_voucher()
    {
        $journalVoucher = JournalVoucher::factory()->create();

        $resp = $this->journalVoucherRepo->delete($journalVoucher->id);

        $this->assertTrue($resp);
        $this->assertNull(JournalVoucher::find($journalVoucher->id), 'JournalVoucher should not exist in DB');
    }
}
