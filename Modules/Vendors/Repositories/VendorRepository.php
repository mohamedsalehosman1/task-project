<?php

namespace Modules\Vendors\Repositories;

use App\Enums\WasherStatusEnum;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Modules\Accounts\Entities\Admin;
use Modules\Vendors\Entities\Scopes\NotBlockedScope;
use Modules\Vendors\Http\Filters\VendorFilter;
use Modules\Contracts\CrudRepository;
use Modules\Vendors\Entities\Vendor;
use Modules\Vendors\Events\VendorStatusEvent;

class VendorRepository implements CrudRepository
{
    /**
     * @var VendorFilter
     */
    private $filter;

    /**
     * VendorRepository constructor.
     *
     * @param VendorFilter $filter
     */
    public function __construct(VendorFilter $filter)
    {
        $this->filter = $filter;
    }


    /**
     * Get all clients as a collection.
     *
     * @return LengthAwarePaginator
     */
    public function all()
    {
        return Vendor::filter($this->filter)->whereStatus(WasherStatusEnum::ACCEPTED->value)->withoutGlobalScope(new NotBlockedScope())->latest()->paginate(request('perPage'));
    }


    public function allApi()
    {
        return Vendor::filter($this->filter)->latest()->paginate(request('perPage'));
    }

    public function requests()
    {
        return Vendor::filter($this->filter)->whereStatus(WasherStatusEnum::PENDING->value)->latest()->paginate(request('perPage'));
    }
    /**
     * Save the created model to storage.
     *
     * @param array $data
     * @return Vendor
     */
    public function create(array $data)
    {
        $vendor = Vendor::create($data);

        // $vendor->setVerified();

        $vendor->addMediaFromRequest('image')->toMediaCollection('images');

        foreach ($data["banners"] as $banner) {
            $vendor->addMedia($banner)->toMediaCollection('banners');
        }

        /** create admin **/
        $admin = $vendor->admin()->create([
            'name' => $data['name:en'],
            'phone'=>$data['phone'],
            'email' => $data['email'],
            'password' => $data['password'],
            'belongs_to_vendor' => true,
        ]);

        $admin->attachRole('vendor');

        return $vendor;
    }

    /**
     * Display the given Vendor instance.
     *
     * @param mixed $model
     * @return Vendor
     */
    // public function find($model)
    // {
    //     return Vendor::withTrashed()->withoutGlobalScope(new NotBlockedScope())->findOrFail($model);
    // }
    public function find($model)
    {
        if ($model instanceof Vendor) {
            return $model;
        }

        return Vendor::withoutGlobalScope(new NotBlockedScope())->findOrFail($model);
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

        $vendor = $this->find($model);
        $vendor->update($data);
        unset($data['phone']);
        $vendor->admin->update($data);

        if (isset($data['image'])) {
            $vendor->clearMediaCollection('images');
            $vendor->addMediaFromRequest('image')->toMediaCollection('images');
        }

        if (isset($data['banners'])) {
            foreach ($data["banners"] as $banner) {
                $vendor->addMedia($banner)->toMediaCollection('banners');
            }
        }

        return $vendor;
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
        $vendor = $this->find($model);
        $vendor->delete();
        $vendor->admin()->delete();
    }

    /**
     * get trashed Vendors
     * @return LengthAwarePaginator
     */
    public function trashed()
    {
        return Vendor::onlyTrashed()->filter($this->filter)->paginate(request('perPage'));
    }

 public function changeStatus($model): void
    {
        $vendor = $this->find($model);
        $vendor->update([
            'status' => request('status'),
        ]);
        event(new VendorStatusEvent($vendor->refresh()));
    }
    /**
     * hard delete
     * @param mixed $model
     * @throws Exception
     */
    public function forceDelete($model)
    {
        $this->find($model)->forceDelete();
    }


    /**
     * restore Vendor
     * @param mixed $model
     * @throws Exception
     */
    public function restore($model)
    {
        $vendor = $this->find($model);
        $vendor->restore();
        $vendor->admin()->restore();
    }


    /**
     * @param Vendor $vendor
     * @return Vendor
     */
    public function block($vendor)
    {
        $vendor->block()->save();
        $vendor->admin->block()->save();

        $vendor->tokens()->delete();

        $vendor->update([
            'device_token' => null
        ]);

        return $vendor;
    }

    /**
     * @param Vendor $vendor
     * @return Vendor
     */
    public function unblock($vendor)
    {
        $vendor->unblock()->save();
        $vendor->admin->unblock()->save();

        return $vendor;
    }
}
