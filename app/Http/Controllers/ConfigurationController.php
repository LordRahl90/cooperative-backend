<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateConfigurationRequest;
use App\Http\Requests\UpdateConfigurationRequest;
use App\Models\Company;
use App\Models\Configuration;
use App\Models\OrgAccountCategory;
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
     * @param $account
     * @return Response
     */
    public function index(Request $request, $account)
    {
        $companyID = session('company_id');
        $configurations = $this->configurationRepository->where("company_id", $companyID);

        return view('configurations.index', [
            'account' => $account
        ])
            ->with('configurations', $configurations);
    }

    /**
     * Show the form for creating a new Configuration.
     *
     * @param Request $request
     * @param $account
     * @return Response
     */
    public function create(Request $request, $account)
    {
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $categories = [];

        if (session('company_id') > 0) {
            $categories = OrgAccountCategory::orderBy('name', 'asc')->where("company_id", session('company_id'))->pluck('name', 'id');
        }
        return view('configurations.create', [
            'account' => $account,
            'companies' => $companies,
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created Configuration in storage.
     *
     * @param CreateConfigurationRequest $request
     *
     * @param $account
     * @return Response
     */
    public function store(CreateConfigurationRequest $request,$account)
    {
        $input = $request->all();
        $companyID = $input['company_id'];
        if (Configuration::where("company_id", $companyID)->count() > 0) {
            Flash::error("You can have only one configuration for your organization");
            return redirect()->back()->withInput();
        }

        //TODO: Prevent using same account id for different config.
        $configuration = $this->configurationRepository->create($input);

        Flash::success('Configuration saved successfully.');

        return redirect(route('configurations.index',$account));
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
        $companies = Company::orderBy('name', 'desc')->pluck('name', 'id');
        $categories = OrgAccountCategory::orderBy('name', 'asc')->pluck('name', 'id');
        $configuration = $this->configurationRepository->find($id);

        if (empty($configuration)) {
            Flash::error('Configuration not found');

            return redirect(route('configurations.index'));
        }

        return view('configurations.edit', [
            'companies' => $companies,
            'categories' => $categories
        ])->with('configuration', $configuration);
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
     * @return Response
     * @throws \Exception
     *
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
