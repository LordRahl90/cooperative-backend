<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Receipt;

class ReceiptApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_receipt()
    {
        $receipt = Receipt::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/receipts', $receipt
        );

        $this->assertApiResponse($receipt);
    }

    /**
     * @test
     */
    public function test_read_receipt()
    {
        $receipt = Receipt::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/receipts/'.$receipt->id
        );

        $this->assertApiResponse($receipt->toArray());
    }

    /**
     * @test
     */
    public function test_update_receipt()
    {
        $receipt = Receipt::factory()->create();
        $editedReceipt = Receipt::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/receipts/'.$receipt->id,
            $editedReceipt
        );

        $this->assertApiResponse($editedReceipt);
    }

    /**
     * @test
     */
    public function test_delete_receipt()
    {
        $receipt = Receipt::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/receipts/'.$receipt->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/receipts/'.$receipt->id
        );

        $this->response->assertStatus(404);
    }
}
