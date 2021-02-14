<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\JournalVoucher;

class JournalVoucherApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_journal_voucher()
    {
        $journalVoucher = JournalVoucher::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/journal_vouchers', $journalVoucher
        );

        $this->assertApiResponse($journalVoucher);
    }

    /**
     * @test
     */
    public function test_read_journal_voucher()
    {
        $journalVoucher = JournalVoucher::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/journal_vouchers/'.$journalVoucher->id
        );

        $this->assertApiResponse($journalVoucher->toArray());
    }

    /**
     * @test
     */
    public function test_update_journal_voucher()
    {
        $journalVoucher = JournalVoucher::factory()->create();
        $editedJournalVoucher = JournalVoucher::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/journal_vouchers/'.$journalVoucher->id,
            $editedJournalVoucher
        );

        $this->assertApiResponse($editedJournalVoucher);
    }

    /**
     * @test
     */
    public function test_delete_journal_voucher()
    {
        $journalVoucher = JournalVoucher::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/journal_vouchers/'.$journalVoucher->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/journal_vouchers/'.$journalVoucher->id
        );

        $this->response->assertStatus(404);
    }
}
