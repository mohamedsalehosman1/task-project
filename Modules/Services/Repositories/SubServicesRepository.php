<?php

namespace Modules\Services\Repositories;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Modules\Services\Entities\Service;
use Modules\Services\Http\Filters\ServiceFilter;
use Modules\Contracts\ChildCrudRepository;

class SubServicesRepository implements ChildCrudRepository
{
    /**
     * @var ServiceFilter
     */
    private $filter;

    /**
     * UserRepository constructor.
     *
     * @param ServiceFilter $filter
     */
    public function __construct(ServiceFilter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Get all clients as a collection.
     *
     * @return LengthAwarePaginator
     */
    public function all($parent)
    {
        return $parent->subServices()->filter($this->filter)->latest()->paginate(request('perPage'));
    }

    /**
     * Save the created model to storage.
     *
     * @param array $data
     * @return Service
     */
    public function create($parent, array $data)
    {
        $service = $parent->subServices()->create($data);

        if (isset($data['image'])) {
            $service->addMediaFromRequest('image')->toMediaCollection('images');
        }

        if (isset($data['additional_image'])) {
            $service->addMediaFromRequest('additional_image')->toMediaCollection('additional_images');
        }

        return $service;
    }

    /**
     * Display the given user instance.
     *
     * @param mixed $model
     * @return Service
     */
    public function find($model)
    {
        if ($model instanceof Service) {
            return $model;
        }

        return Service::findOrFail($model);
    }

    /**
     * Update the given client in the storage.
     *
     * @param mixed $model
     * @param array $data
     * @return Model
     */
    public function update($model, array $data)
    {
        $model->update($data);

        if (isset($data['image'])) {
            $model->clearMediaCollection('images');
            $model->addMediaFromRequest('image')->toMediaCollection('images');
        }


        if (isset($data['additional_image'])) {
            $model->clearMediaCollection('additional_images');
            $model->addMediaFromRequest('additional_image')->toMediaCollection('additional_images');
        }

        return $model;
    }

    /**
     * Delete the given client from storage.
     *
     * @param mixed $model
     * @return void
     * @throws Exception
     */
    public function delete($model)
    {
        $this->find($model)->forceDelete();
    }

}
