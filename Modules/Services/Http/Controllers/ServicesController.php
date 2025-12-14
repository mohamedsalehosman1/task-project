<?php

namespace Modules\Services\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Services\Entities\Service;
use Modules\Services\Http\Requests\ServiceRequest;
use Modules\Services\Repositories\ServiceRepository;
use Modules\Services\Repositories\SubServicesRepository;

class ServicesController extends Controller
{
    private $repository;

    public function __construct(ServiceRepository $repository)
    {
        $this->middleware('permission:read_services')->only(['index']);
        $this->middleware('permission:create_services')->only(['create', 'store']);
        $this->middleware('permission:update_services')->only(['edit', 'update']);
        $this->middleware('permission:delete_services')->only(['destroy']);
        $this->middleware('permission:show_services')->only(['show']);
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $services = $this->repository->all();
        return view('services::services.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $services = Service::listsTranslations('name')->pluck('name', 'id')->toArray();

        return view('services::services.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ServiceRequest $request
     */
 // Modules\Services\Http\Controllers\ServicesController.php
public function store(ServiceRequest $request)
{
    // 1. استثناء التوكن والصورة من البيانات المباشرة للسجل
    $data = $request->except('_token', 'image'); // استبعد 'image' أيضاً من $data

    // 2. إنشاء السجل (دون التعامل مع الصورة بعد)
    // يجب أن تكون دالة create في الـ repository لا تتوقع معالجة الصورة
    $service = $this->repository->create($data);

    // 3. التعامل مع رفع الصورة مباشرة في الكنترولر (حيث لا يزال $request متاحاً)
    if ($request->hasFile('image')) {
        // نستخدم $request مباشرة
        $service->addMediaFromRequest('image')->toMediaCollection('images');
    }

    // (أو إذا كنت تستخدم حقول ترجمة متعددة اللغات، تأكد من استثناء الحقول غير المتعلقة بالصورة)
    // مثال لطلبك:
    /*
    $data = $request->except('_token', 'name:en', 'name:ar', 'image'); // استثناء الصورة
    $service = $this->repository->create($request->except('_token', 'image'));

    if ($request->hasFile('image')) {
        $service->addMediaFromRequest('image')->toMediaCollection('images');
    }
    */

    flash(trans('services::services.messages.created'))->success();

    return redirect()->route('dashboard.services.show', $service);
}


    /**
     * Display the specified resource.
     *
     * @param Service $service
     * @return View
     */
    public function show(Service $service)
    {
        $service = $this->repository->find($service);

        return view('services::services.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Service $service
     * @return View
     */
    public function edit(Service $service)
    {
        $service = $this->repository->find($service);
        $services = Service::listsTranslations('name')->pluck('name', 'id')->toArray();

        return view('services::services.edit', compact('service', 'services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ServiceRequest $request
     * @param Service $service
     */
    public function update(ServiceRequest $request, Service $service)
    {
        $data = $request->all();
        $service = $this->repository->update($service, $data);

        flash(trans('services::services.messages.updated'))->success();

        return redirect()->route('dashboard.services.show', $service);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Service $service
     */
    public function destroy(Service $service)
    {
        // $exists = $this->canDelete($service);

            $this->repository->delete($service);


        flash(trans('services::services.messages.deleted' ))->error();

        return redirect()->route('dashboard.services.index');
    }

    // public function canDelete($service)
    // {
    //     return $service->product->count() > 0;
    // }


}
