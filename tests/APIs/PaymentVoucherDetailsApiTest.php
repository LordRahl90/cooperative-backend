<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\PaymentVoucherDetails;

class PaymentVoucherDetailsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_payment_voucher_details()
    {
        $paymentVoucherDetails = PaymentVoucherDetails::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/payment_voucher_details', $paymentVoucherDetails
        );

        $this->assertApiResponse($paymentVoucherDetails);
    }

    /**
     * @test
     */
    public function test_read_payment_voucher_details()
    {
        $paymentVoucherDetails = PaymentVoucherDetails::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/payment_voucher_details/'.$paymentVoucherDetails->id
        );

        $this->assertApiResponse($paymentVoucherDetails->toArray());
    }

    /**
     * @test
     */
    public function test_update_payment_voucher_details()
    {
        $paymentVoucherDetails = PaymentVoucherDetails::factory()->create();
        $editedPaymentVoucherDetails = PaymentVoucherDetails::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/payment_voucher_details/'.$paymentVoucherDetails->id,
            $editedPaymentVoucherDetails
        );

        $this->assertApiResponse($editedPaymentVoucherDetails);
    }

    /**
     * @test
     */
    public function test_delete_payment_voucher_details()
    {
        $paymentVoucherDetails = PaymentVoucherDetails::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/payment_voucher_details/'.$paymentVoucherDetails->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/payment_voucher_details/'.$paymentVoucherDetails->id
        );

        $this->response->assertStatus(404);
    }
}
