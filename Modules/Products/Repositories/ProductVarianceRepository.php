<?php

namespace Modules\Products\Repositories;

use Modules\Contracts\CrudRepository;
use Modules\Products\Entities\ProductVariance;
use Modules\Products\Http\Filters\ProductVarianceFilter;

class ProductVarianceRepository implements CrudRepository
{
    /**
     * @var \Modules\Products\Http\Filters\ProductFilter
     */
    private $filter;

    /**
     * ProductRepository constructor.
     *
     * @param \Modules\Products\Http\Filters\ProductVariance $filter
     */
    public function __construct(ProductVarianceFilter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Get all Products as a collection.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all()
    {
        return ProductVariance::whereProductId(request()->product->id)->filter($this->filter)->groupBy('size_id')->paginate(request('perPage'));
    }

    /**
     * Get all Products as a collection.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function allApi()
    {
        return ProductVariance::filter($this->filter)->paginate(request('perPage'));
    }

    /**
     * Save the created model to storage.
     *
     * @param array $data
     * @return \Modules\Products\Entities\Product
     */
    public function create(array $data)
    {
        foreach ($data['quantity'] as $color => $quantity) {
            $variances[] = [
                'product_id' => $data['product_id'],
                'size_id' => $data['size_id'],
                'color_id' => $color,
                'quantity' => $quantity
            ];
        }

        $variances = ProductVariance::insert($variances);

        return $variances;
    }

    /**
     * Display the given Product instance.
     *
     * @param mixed $model
     * @return \Modules\Products\Entities\Product
     */
    public function find($model)
    {
        if ($model instanceof ProductVariance) {
            return $model;
        }

        return ProductVariance::findOrFail($model);
    }

    /**
     * Update the given Product in the storage.
     *
     * @param mixed $model
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($model, array $data)
    {
        $model->productVariances()->whereSizeId($data['size_id'])->delete();

        foreach ($data['quantity'] as $color => $quantity) {

            $model->productVariances()->withTrashed()->updateOrCreate(
                [
                    'size_id' => $data['size_id'],
                    'color_id' => $color
                ],
                [
                    'quantity' => $quantity,
                    'deleted_at' => null
                ]
            );
        }

        return true;
    }

    /**
     * Delete the given Product from storage.
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
