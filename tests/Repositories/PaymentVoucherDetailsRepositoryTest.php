<?php namespace Tests\Repositories;

use App\Models\PaymentVoucherDetails;
use App\Repositories\PaymentVoucherDetailsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PaymentVoucherDetailsRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PaymentVoucherDetailsRepository
     */
    protected $paymentVoucherDetailsRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->paymentVoucherDetailsRepo = \App::make(PaymentVoucherDetailsRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_payment_voucher_details()
    {
        $paymentVoucherDetails = PaymentVoucherDetails::factory()->make()->toArray();

        $createdPaymentVoucherDetails = $this->paymentVoucherDetailsRepo->create($paymentVoucherDetails);

        $createdPaymentVoucherDetails = $createdPaymentVoucherDetails->toArray();
        $this->assertArrayHasKey('id', $createdPaymentVoucherDetails);
        $this->assertNotNull($createdPaymentVoucherDetails['id'], 'Created PaymentVoucherDetails must have id specified');
        $this->assertNotNull(PaymentVoucherDetails::find($createdPaymentVoucherDetails['id']), 'PaymentVoucherDetails with given id must be in DB');
        $this->assertModelData($paymentVoucherDetails, $createdPaymentVoucherDetails);
    }

    /**
     * @test read
     */
    public function test_read_payment_voucher_details()
    {
        $paymentVoucherDetails = PaymentVoucherDetails::factory()->create();

        $dbPaymentVoucherDetails = $this->paymentVoucherDetailsRepo->find($paymentVoucherDetails->id);

        $dbPaymentVoucherDetails = $dbPaymentVoucherDetails->toArray();
        $this->assertModelData($paymentVoucherDetails->toArray(), $dbPaymentVoucherDetails);
    }

    /**
     * @test update
     */
    public function test_update_payment_voucher_details()
    {
        $paymentVoucherDetails = PaymentVoucherDetails::factory()->create();
        $fakePaymentVoucherDetails = PaymentVoucherDetails::factory()->make()->toArray();

        $updatedPaymentVoucherDetails = $this->paymentVoucherDetailsRepo->update($fakePaymentVoucherDetails, $paymentVoucherDetails->id);

        $this->assertModelData($fakePaymentVoucherDetails, $updatedPaymentVoucherDetails->toArray());
        $dbPaymentVoucherDetails = $this->paymentVoucherDetailsRepo->find($paymentVoucherDetails->id);
        $this->assertModelData($fakePaymentVoucherDetails, $dbPaymentVoucherDetails->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_payment_voucher_details()
    {
        $paymentVoucherDetails = PaymentVoucherDetails::factory()->create();

        $resp = $this->paymentVoucherDetailsRepo->delete($paymentVoucherDetails->id);

        $this->assertTrue($resp);
        $this->assertNull(PaymentVoucherDetails::find($paymentVoucherDetails->id), 'PaymentVoucherDetails should not exist in DB');
    }
}
