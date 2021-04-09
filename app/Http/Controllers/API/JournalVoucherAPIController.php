<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateJournalVoucherAPIRequest;
use App\Http\Requests\API\UpdateJournalVoucherAPIRequest;
use App\Models\JournalVoucher;
use App\Repositories\JournalVoucherRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class JournalVoucherController
 * @package App\Http\Controllers\API
 */

class JournalVoucherAPIController extends AppBaseController
{
    /** @var  JournalVoucherRepository */
    private $journalVoucherRepository;

    public function __construct(JournalVoucherRepository $journalVoucherRepo)
    {
        $this->journalVoucherRepository = $journalVoucherRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/journalVouchers",
     *      summary="Get a listing of the JournalVouchers.",
     *      tags={"JournalVoucher"},
     *      description="Get all JournalVouchers",
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
     *                  @SWG\Items(ref="#/definitions/JournalVoucher")
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
        $journalVouchers = $this->journalVoucherRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($journalVouchers->toArray(), 'Journal Vouchers retrieved successfully');
    }

    /**
     * @param CreateJournalVoucherAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/journalVouchers",
     *      summary="Store a newly created JournalVoucher in storage",
     *      tags={"JournalVoucher"},
     *      description="Store JournalVoucher",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="JournalVoucher that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/JournalVoucher")
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
     *                  ref="#/definitions/JournalVoucher"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateJournalVoucherAPIRequest $request)
    {
        $input = $request->all();

        $journalVoucher = $this->journalVoucherRepository->create($input);

        return $this->sendResponse($journalVoucher->toArray(), 'Journal Voucher saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/journalVouchers/{id}",
     *      summary="Display the specified JournalVoucher",
     *      tags={"JournalVoucher"},
     *      description="Get JournalVoucher",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of JournalVoucher",
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
     *                  ref="#/definitions/JournalVoucher"
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
        /** @var JournalVoucher $journalVoucher */
        $journalVoucher = $this->journalVoucherRepository->find($id);

        if (empty($journalVoucher)) {
            return $this->sendError('Journal Voucher not found');
        }

        return $this->sendResponse($journalVoucher->toArray(), 'Journal Voucher retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateJournalVoucherAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/journalVouchers/{id}",
     *      summary="Update the specified JournalVoucher in storage",
     *      tags={"JournalVoucher"},
     *      description="Update JournalVoucher",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of JournalVoucher",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="JournalVoucher that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/JournalVoucher")
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
     *                  ref="#/definitions/JournalVoucher"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateJournalVoucherAPIRequest $request)
    {
        $input = $request->all();

        /** @var JournalVoucher $journalVoucher */
        $journalVoucher = $this->journalVoucherRepository->find($id);

        if (empty($journalVoucher)) {
            return $this->sendError('Journal Voucher not found');
        }

        $journalVoucher = $this->journalVoucherRepository->update($input, $id);

        return $this->sendResponse($journalVoucher->toArray(), 'JournalVoucher updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/journalVouchers/{id}",
     *      summary="Remove the specified JournalVoucher from storage",
     *      tags={"JournalVoucher"},
     *      description="Delete JournalVoucher",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of JournalVoucher",
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
        /** @var JournalVoucher $journalVoucher */
        $journalVoucher = $this->journalVoucherRepository->find($id);

        if (empty($journalVoucher)) {
            return $this->sendError('Journal Voucher not found');
        }

        $journalVoucher->delete();

        return $this->sendSuccess('Journal Voucher deleted successfully');
    }
}
