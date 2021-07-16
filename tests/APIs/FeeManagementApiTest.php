<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\FeeManagement;

class FeeManagementApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_fee_management()
    {
        $feeManagement = FeeManagement::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/fee_managements', $feeManagement
        );

        $this->assertApiResponse($feeManagement);
    }

    /**
     * @test
     */
    public function test_read_fee_management()
    {
        $feeManagement = FeeManagement::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/fee_managements/'.$feeManagement->id
        );

        $this->assertApiResponse($feeManagement->toArray());
    }

    /**
     * @test
     */
    public function test_update_fee_management()
    {
        $feeManagement = FeeManagement::factory()->create();
        $editedFeeManagement = FeeManagement::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/fee_managements/'.$feeManagement->id,
            $editedFeeManagement
        );

        $this->assertApiResponse($editedFeeManagement);
    }

    /**
     * @test
     */
    public function test_delete_fee_management()
    {
        $feeManagement = FeeManagement::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/fee_managements/'.$feeManagement->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/fee_managements/'.$feeManagement->id
        );

        $this->response->assertStatus(404);
    }
}
