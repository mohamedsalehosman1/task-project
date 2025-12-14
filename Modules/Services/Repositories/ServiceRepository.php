<?php

namespace Modules\Services\Repositories;

use Modules\Contracts\CrudRepository;
use Modules\Services\Entities\Service;
use Modules\Services\Http\Filters\ServiceFilter;

class ServiceRepository implements CrudRepository
{
    /**
     * @var \Modules\Services\Http\Filters\ServiceFilter
     */
    private $filter;

    /**
     * ServiceRepository constructor.
     *
     * @param \Modules\Services\Http\Filters\ServiceFilter $filter
     */
    public function __construct(ServiceFilter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Get all Services as a collection.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all()
    {

        return Service::filter($this->filter)->paginate(request('perPage'));
    }

    /**
     * Save the created model to storage.
     *
     * @param array $data
     * @return \Modules\Services\Entities\Service
     */
   // في الـ Repository الخاص بك (حيث توجد دالة create)
public function create(array $data)
{
    // هذه الدالة الآن مسؤولة فقط عن إنشاء سجل الخدمة
    $service = Service::create($data);

    // *أزل* هذا الجزء:
    /*
    if (isset($data['image'])) {
        $service->addMediaFromRequest('image')->toMediaCollection('images');
    }
    */

    return $service;
}

    /**
     * Display the given Service instance.
     *
     * @param mixed $model
     * @return \Modules\Services\Entities\Service
     */
    public function find($model)
    {
        if ($model instanceof Service) {
            return $model;
        }

        return Service::findOrFail($model);
    }

    /**
     * Update the given Service in the storage.
     *
     * @param mixed $model
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($model, array $data)
    {
        $model->update($data);

        if (isset($data['image'])) {
            $model->clearMediaCollection('images');
            $model->addMediaFromRequest('image')->toMediaCollection('images');
        }

        return $model;
    }

    /**
     * Delete the given Service from storage.
     *
     * @param mixed $model
     * @return void
     * @throws \Exception
     */
    public function delete($model)
    {
        $this->find($model)->delete();
    }
}
