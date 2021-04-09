<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateReceiptAPIRequest;
use App\Http\Requests\API\UpdateReceiptAPIRequest;
use App\Models\Receipt;
use App\Repositories\ReceiptRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ReceiptController
 * @package App\Http\Controllers\API
 */

class ReceiptAPIController extends AppBaseController
{
    /** @var  ReceiptRepository */
    private $receiptRepository;

    public function __construct(ReceiptRepository $receiptRepo)
    {
        $this->receiptRepository = $receiptRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/receipts",
     *      summary="Get a listing of the Receipts.",
     *      tags={"Receipt"},
     *      description="Get all Receipts",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Receipt")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $receipts = $this->receiptRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($receipts->toArray(), 'Receipts retrieved successfully');
    }

    /**
     * @param CreateReceiptAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/receipts",
     *      summary="Store a newly created Receipt in storage",
     *      tags={"Receipt"},
     *      description="Store Receipt",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Receipt that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Receipt")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Receipt"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateReceiptAPIRequest $request)
    {
        $input = $request->all();

        $receipt = $this->receiptRepository->create($input);

        return $this->sendResponse($receipt->toArray(), 'Receipt saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/receipts/{id}",
     *      summary="Display the specified Receipt",
     *      tags={"Receipt"},
     *      description="Get Receipt",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Receipt",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Receipt"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Receipt $receipt */
        $receipt = $this->receiptRepository->find($id);

        if (empty($receipt)) {
            return $this->sendError('Receipt not found');
        }

        return $this->sendResponse($receipt->toArray(), 'Receipt retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateReceiptAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/receipts/{id}",
     *      summary="Update the specified Receipt in storage",
     *      tags={"Receipt"},
     *      description="Update Receipt",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Receipt",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Receipt that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Receipt")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Receipt"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateReceiptAPIRequest $request)
    {
        $input = $request->all();

        /** @var Receipt $receipt */
        $receipt = $this->receiptRepository->find($id);

        if (empty($receipt)) {
            return $this->sendError('Receipt not found');
        }

        $receipt = $this->receiptRepository->update($input, $id);

        return $this->sendResponse($receipt->toArray(), 'Receipt updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/receipts/{id}",
     *      summary="Remove the specified Receipt from storage",
     *      tags={"Receipt"},
     *      description="Delete Receipt",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Receipt",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Receipt $receipt */
        $receipt = $this->receiptRepository->find($id);

        if (empty($receipt)) {
            return $this->sendError('Receipt not found');
        }

        $receipt->delete();

        return $this->sendSuccess('Receipt deleted successfully');
    }
}
