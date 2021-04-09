<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateStaffAPIRequest;
use App\Http\Requests\API\UpdateStaffAPIRequest;
use App\Models\Staff;
use App\Repositories\StaffRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class StaffController
 * @package App\Http\Controllers\API
 */

class StaffAPIController extends AppBaseController
{
    /** @var  StaffRepository */
    private $staffRepository;

    public function __construct(StaffRepository $staffRepo)
    {
        $this->staffRepository = $staffRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/staff",
     *      summary="Get a listing of the Staff.",
     *      tags={"Staff"},
     *      description="Get all Staff",
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
     *                  @SWG\Items(ref="#/definitions/Staff")
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
        $staff = $this->staffRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($staff->toArray(), 'Staff retrieved successfully');
    }

    /**
     * @param CreateStaffAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/staff",
     *      summary="Store a newly created Staff in storage",
     *      tags={"Staff"},
     *      description="Store Staff",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Staff that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Staff")
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
     *                  ref="#/definitions/Staff"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateStaffAPIRequest $request)
    {
        $input = $request->all();

        $staff = $this->staffRepository->create($input);

        return $this->sendResponse($staff->toArray(), 'Staff saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/staff/{id}",
     *      summary="Display the specified Staff",
     *      tags={"Staff"},
     *      description="Get Staff",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Staff",
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
     *                  ref="#/definitions/Staff"
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
        /** @var Staff $staff */
        $staff = $this->staffRepository->find($id);

        if (empty($staff)) {
            return $this->sendError('Staff not found');
        }

        return $this->sendResponse($staff->toArray(), 'Staff retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateStaffAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/staff/{id}",
     *      summary="Update the specified Staff in storage",
     *      tags={"Staff"},
     *      description="Update Staff",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Staff",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Staff that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Staff")
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
     *                  ref="#/definitions/Staff"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateStaffAPIRequest $request)
    {
        $input = $request->all();

        /** @var Staff $staff */
        $staff = $this->staffRepository->find($id);

        if (empty($staff)) {
            return $this->sendError('Staff not found');
        }

        $staff = $this->staffRepository->update($input, $id);

        return $this->sendResponse($staff->toArray(), 'Staff updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/staff/{id}",
     *      summary="Remove the specified Staff from storage",
     *      tags={"Staff"},
     *      description="Delete Staff",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Staff",
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
        /** @var Staff $staff */
        $staff = $this->staffRepository->find($id);

        if (empty($staff)) {
            return $this->sendError('Staff not found');
        }

        $staff->delete();

        return $this->sendSuccess('Staff deleted successfully');
    }
}
