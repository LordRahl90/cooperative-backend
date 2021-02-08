<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateConfigurationRequest;
use App\Http\Requests\UpdateConfigurationRequest;
use App\Repositories\ConfigurationRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class ConfigurationController extends AppBaseController
{
    /** @var  ConfigurationRepository */
    private $configurationRepository;

    public function __construct(ConfigurationRepository $configurationRepo)
    {
        $this->configurationRepository = $configurationRepo;
    }

    /**
     * Display a listing of the Configuration.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $configurations = $this->configurationRepository->all();

        return view('configurations.index')
            ->with('configurations', $configurations);
    }

    /**
     * Show the form for creating a new Configuration.
     *
     * @return Response
     */
    public function create()
    {
        return view('configurations.create');
    }

    /**
     * Store a newly created Configuration in storage.
     *
     * @param CreateConfigurationRequest $request
     *
     * @return Response
     */
    public function store(CreateConfigurationRequest $request)
    {
        $input = $request->all();

        $configuration = $this->configurationRepository->create($input);

        Flash::success('Configuration saved successfully.');

        return redirect(route('configurations.index'));
    }

    /**
     * Display the specified Configuration.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $configuration = $this->configurationRepository->find($id);

        if (empty($configuration)) {
            Flash::error('Configuration not found');

            return redirect(route('configurations.index'));
        }

        return view('configurations.show')->with('configuration', $configuration);
    }

    /**
     * Show the form for editing the specified Configuration.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $configuration = $this->configurationRepository->find($id);

        if (empty($configuration)) {
            Flash::error('Configuration not found');

            return redirect(route('configurations.index'));
        }

        return view('configurations.edit')->with('configuration', $configuration);
    }

    /**
     * Update the specified Configuration in storage.
     *
     * @param int $id
     * @param UpdateConfigurationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateConfigurationRequest $request)
    {
        $configuration = $this->configurationRepository->find($id);

        if (empty($configuration)) {
            Flash::error('Configuration not found');

            return redirect(route('configurations.index'));
        }

        $configuration = $this->configurationRepository->update($request->all(), $id);

        Flash::success('Configuration updated successfully.');

        return redirect(route('configurations.index'));
    }

    /**
     * Remove the specified Configuration from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $configuration = $this->configurationRepository->find($id);

        if (empty($configuration)) {
            Flash::error('Configuration not found');

            return redirect(route('configurations.index'));
        }

        $this->configurationRepository->delete($id);

        Flash::success('Configuration deleted successfully.');

        return redirect(route('configurations.index'));
    }
}
