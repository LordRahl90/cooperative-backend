<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateConfigurationAPIRequest;
use App\Http\Requests\API\UpdateConfigurationAPIRequest;
use App\Models\Configuration;
use App\Repositories\ConfigurationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ConfigurationController
 * @package App\Http\Controllers\API
 */

class ConfigurationAPIController extends AppBaseController
{
    /** @var  ConfigurationRepository */
    private $configurationRepository;

    public function __construct(ConfigurationRepository $configurationRepo)
    {
        $this->configurationRepository = $configurationRepo;
    }

    /**
     * Display a listing of the Configuration.
     * GET|HEAD /configurations
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $configurations = $this->configurationRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($configurations->toArray(), 'Configurations retrieved successfully');
    }

    /**
     * Store a newly created Configuration in storage.
     * POST /configurations
     *
     * @param CreateConfigurationAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateConfigurationAPIRequest $request)
    {
        $input = $request->all();

        $configuration = $this->configurationRepository->create($input);

        return $this->sendResponse($configuration->toArray(), 'Configuration saved successfully');
    }

    /**
     * Display the specified Configuration.
     * GET|HEAD /configurations/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Configuration $configuration */
        $configuration = $this->configurationRepository->find($id);

        if (empty($configuration)) {
            return $this->sendError('Configuration not found');
        }

        return $this->sendResponse($configuration->toArray(), 'Configuration retrieved successfully');
    }

    /**
     * Update the specified Configuration in storage.
     * PUT/PATCH /configurations/{id}
     *
     * @param int $id
     * @param UpdateConfigurationAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateConfigurationAPIRequest $request)
    {
        $input = $request->all();

        /** @var Configuration $configuration */
        $configuration = $this->configurationRepository->find($id);

        if (empty($configuration)) {
            return $this->sendError('Configuration not found');
        }

        $configuration = $this->configurationRepository->update($input, $id);

        return $this->sendResponse($configuration->toArray(), 'Configuration updated successfully');
    }

    /**
     * Remove the specified Configuration from storage.
     * DELETE /configurations/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Configuration $configuration */
        $configuration = $this->configurationRepository->find($id);

        if (empty($configuration)) {
            return $this->sendError('Configuration not found');
        }

        $configuration->delete();

        return $this->sendSuccess('Configuration deleted successfully');
    }
}
