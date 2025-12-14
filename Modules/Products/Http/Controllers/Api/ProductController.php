<?php

namespace Modules\Products\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Modules\Products\Entities\Product;
use Modules\Products\Repositories\ProductRepository;
use Modules\Products\Transformers\ProductBreifResource;
use Modules\Products\Transformers\ProductResource;
use Modules\Support\Traits\ApiTrait;

class ProductController extends Controller
{
    use ApiTrait;

    /**
     * @var ProductRepository
     */
    private $repository;

    /**
     * CountryController constructor.
     *
     * @param ProductRepository $repository
     *
     */
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $products = $this->repository->allApi();
        return $this->sendResponse(ProductBreifResource::collection($products)->response()->getData(true), __('Data Found'));
    }

    public function show(Product $product)
    {
        return $this->sendResponse(new ProductResource($product), __('Data Found'));
    }
}
