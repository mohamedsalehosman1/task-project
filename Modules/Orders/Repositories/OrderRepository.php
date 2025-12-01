<?php

namespace Modules\Orders\Repositories;

use App\Enums\OrderStatusEnum;
use App\Services\PaymentGateways\MyfatoorahService;
use Auth;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Laraeast\LaravelSettings\Facades\Settings;
use Modules\Accounts\Entities\User;
use Modules\Addresses\Entities\Address;
use Modules\Contracts\CrudRepository;
use Modules\Coupons\Entities\Coupon;
use Modules\Coupons\Http\Filters\CouponFilter;
use Modules\Coupons\Repositories\CouponRepository;
use Modules\Items\Entities\Item;
use Modules\Orders\Entities\Order;
use Modules\Orders\Entities\OrderItem;
use Modules\Orders\Entities\OrderTax;
use Modules\Orders\Entities\OrderVendor;
use Modules\Orders\Entities\OrderVendorItem;
use Modules\Orders\Http\Filters\OrderFilter;
use Modules\Services\Entities\Service;
use Modules\Services\Entities\VendorService;
use Modules\Support\Traits\ApiTrait;
use Modules\Taxes\Entities\Tax;
use Modules\Vendors\Entities\Vendor;

class OrderRepository implements CrudRepository
{
    use ApiTrait;
    private $filter;
    /**
     * OrderRepository constructor.
     * @param OrderFilter $filter
     */
    public function __construct(OrderFilter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function all()
    {
        if (auth()->user()->hasRole('vendor')) {
            $vendor = auth()->user()->vendor;
            return $vendor->orders()->filter($this->filter)->latest()->paginate(request('perPage'));
        }

        return Order::filter($this->filter)->latest()->paginate(request('perPage'));
    }

    /**
     * @param array $data
     * @return void
     */
    public function create(array $data)
    {
        //
    }

    /**
     * @param mixed $model
     * @return Model|void
     */
    public function find($model)
    {
        return Order::findOrFail($model);
    }

    /**
     * @param mixed $model
     * @param array $data
     * @return void
     */
    public function update($model, array $data)
    {
        //
    }

    /**
     * @param mixed $model
     */
    public function delete($model)
    {
        $this->find($model)->delete();
    }


    /**
     * @return mixed
     */
    public function customer()
    {
        $customer = User::findOrFail(auth()->id());
        return $customer->orders()->filter($this->filter)->latest()->paginate(request('perPage'));
    }













}
