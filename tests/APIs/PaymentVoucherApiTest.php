<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\PaymentVoucher;

class PaymentVoucherApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_payment_voucher()
    {
        $paymentVoucher = PaymentVoucher::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/payment_vouchers', $paymentVoucher
        );

        $this->assertApiResponse($paymentVoucher);
    }

    /**
     * @test
     */
    public function test_read_payment_voucher()
    {
        $paymentVoucher = PaymentVoucher::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/payment_vouchers/'.$paymentVoucher->id
        );

        $this->assertApiResponse($paymentVoucher->toArray());
    }

    /**
     * @test
     */
    public function test_update_payment_voucher()
    {
        $paymentVoucher = PaymentVoucher::factory()->create();
        $editedPaymentVoucher = PaymentVoucher::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/payment_vouchers/'.$paymentVoucher->id,
            $editedPaymentVoucher
        );

        $this->assertApiResponse($editedPaymentVoucher);
    }

    /**
     * @test
     */
    public function test_delete_payment_voucher()
    {
        $paymentVoucher = PaymentVoucher::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/payment_vouchers/'.$paymentVoucher->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/payment_vouchers/'.$paymentVoucher->id
        );

        $this->response->assertStatus(404);
    }
}
