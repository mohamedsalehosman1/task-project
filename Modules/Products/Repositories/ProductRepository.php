<?php
namespace Modules\Products\Repositories;

use Modules\Contracts\CrudRepository;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\UserProduct;
use Modules\Products\Http\Filters\ProductFilter;

class ProductRepository implements CrudRepository
{
    /**
     * @var \Modules\Products\Http\Filters\ProductFilter
     */
    private $filter;

    /**
     * ProductRepository constructor.
     *
     * @param \Modules\Products\Http\Filters\ProductFilter $filter
     */
    public function __construct(ProductFilter $filter)
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
        return Product::where('status', 'accepeted')->filter($this->filter)->paginate(request('perPage'));
    }

    /**
     * Get all Products as a collection.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function allApi()
    {
        return Product::where('status', 'accepeted')->filter($this->filter)->paginate(request('perPage'));
    }

    /**
     * Save the created model to storage.
     *
     * @param array $data
     * @return \Modules\Products\Entities\Product
     */

    public function createproduct(array $data)
    {

        $product = Product::create($data);

        $product->addMediaFromRequest('cover')->toMediaCollection('covers');

        if (isset($data['images'])) {
            foreach ($data['images'] as $image) {
                $product->addMedia($image)->toMediaCollection('images');
            }
        }

        return $product;
    }

    public function create(array $data)
    {

        $product = UserProduct::create($data);

        $product->addMediaFromRequest('cover')->toMediaCollection('covers');

        if (isset($data['images'])) {
            foreach ($data['images'] as $image) {
                $product->addMedia($image)->toMediaCollection('images');
            }
        }

        return $product;
    }

    /**
     * Display the given Product instance.
     *
     * @param mixed $model
     * @return \Modules\Products\Entities\Product
     */
    public function find($model)
    {
        if ($model instanceof Product) {
            return $model;
        }

        return Product::findOrFail($model);
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
        $product = $this->find($model);

        $product->update($data);

        if (isset($data['cover'])) {
            $product->clearMediaCollection('covers');
            $product->addMediaFromRequest('cover')->toMediaCollection('covers');
        }

        if (isset($data['images'])) {
            foreach ($data['images'] as $image) {
                $product->addMedia($image)->toMediaCollection('images');
            }
        }
        // $product->materials()->delete();
        // foreach ($data['material'] as $material) {
        //     $product->materials()->create($material);
        // }

        return $product;
    }
public function changeStatus($model): void
    {
        $vendor = $this->find($model);
        $vendor->update([
            'status' => request('status'),
        ]);

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
