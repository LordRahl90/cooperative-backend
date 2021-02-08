<?php namespace Tests\Repositories;

use App\Models\PaymentVoucher;
use App\Repositories\PaymentVoucherRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PaymentVoucherRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PaymentVoucherRepository
     */
    protected $paymentVoucherRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->paymentVoucherRepo = \App::make(PaymentVoucherRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_payment_voucher()
    {
        $paymentVoucher = PaymentVoucher::factory()->make()->toArray();

        $createdPaymentVoucher = $this->paymentVoucherRepo->create($paymentVoucher);

        $createdPaymentVoucher = $createdPaymentVoucher->toArray();
        $this->assertArrayHasKey('id', $createdPaymentVoucher);
        $this->assertNotNull($createdPaymentVoucher['id'], 'Created PaymentVoucher must have id specified');
        $this->assertNotNull(PaymentVoucher::find($createdPaymentVoucher['id']), 'PaymentVoucher with given id must be in DB');
        $this->assertModelData($paymentVoucher, $createdPaymentVoucher);
    }

    /**
     * @test read
     */
    public function test_read_payment_voucher()
    {
        $paymentVoucher = PaymentVoucher::factory()->create();

        $dbPaymentVoucher = $this->paymentVoucherRepo->find($paymentVoucher->id);

        $dbPaymentVoucher = $dbPaymentVoucher->toArray();
        $this->assertModelData($paymentVoucher->toArray(), $dbPaymentVoucher);
    }

    /**
     * @test update
     */
    public function test_update_payment_voucher()
    {
        $paymentVoucher = PaymentVoucher::factory()->create();
        $fakePaymentVoucher = PaymentVoucher::factory()->make()->toArray();

        $updatedPaymentVoucher = $this->paymentVoucherRepo->update($fakePaymentVoucher, $paymentVoucher->id);

        $this->assertModelData($fakePaymentVoucher, $updatedPaymentVoucher->toArray());
        $dbPaymentVoucher = $this->paymentVoucherRepo->find($paymentVoucher->id);
        $this->assertModelData($fakePaymentVoucher, $dbPaymentVoucher->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_payment_voucher()
    {
        $paymentVoucher = PaymentVoucher::factory()->create();

        $resp = $this->paymentVoucherRepo->delete($paymentVoucher->id);

        $this->assertTrue($resp);
        $this->assertNull(PaymentVoucher::find($paymentVoucher->id), 'PaymentVoucher should not exist in DB');
    }
}
