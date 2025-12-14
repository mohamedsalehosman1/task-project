<?php

namespace Modules\Services\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Services\Entities\Service;
use Modules\Services\Http\Requests\ServiceRequest;
use Modules\Services\Repositories\SubServicesRepository;

class SubServicesController extends Controller
{
    private $repository;

    public function __construct(SubServicesRepository $repository)
    {
        $this->middleware('permission:read_services')->only(['index']);
        $this->middleware('permission:create_services')->only(['create', 'store']);
        $this->middleware('permission:update_services')->only(['edit', 'update']);
        $this->middleware('permission:delete_services')->only(['destroy']);
        $this->middleware('permission:show_services')->only(['show']);
        $this->repository = $repository;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param ServiceRequest $request
     */
    public function store(Service $service, ServiceRequest $request)
    {
        $data = $request->except('_token');

        $service = $this->repository->create($service, $data);

        flash(trans('services::sub_services.messages.created'))->success();

        return redirect()->back();
    }


    /**
     * Display the specified resource.
     *
     * @param Service $service
     * @return View
     */
    public function show(Service $service, Service $sub_service)
    {
        return view('services::sub_services.show', compact('sub_service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Service $service
     * @return View
     */
    public function edit(Service $service, $sub_service)
    {
        $service = $this->repository->find($sub_service);

        $services = Service::listsTranslations('name')->pluck('name', 'id')->toArray();

        return view('services::sub_services.edit', compact('service', 'services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ServiceRequest $request
     * @param Service $service
     */
    public function update(ServiceRequest $request, Service $service, Service $sub_service)
    {
        $data = $request->validated();

        $service = $this->repository->update($sub_service, $data);

        flash(trans('services::sub_services.messages.updated'))->success();

        return redirect()->route('dashboard.services.show', $sub_service->parent);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Service $service
     */
    public function destroy(Service $service)
    {
        $exists = $this->canDelete($service);

        if (!$exists) {
            $this->repository->delete($service);
        }

        flash(trans('services::services.messages.' . ($exists ? "cant-delete" : "deleted")))->error();

        return redirect()->route('dashboard.services.index');
    }

    public function canDelete($service)
    {
        return false;
        // return vendorService::whereServiceId($service->id)->count() ;
    }
}
