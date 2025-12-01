<?php

namespace Modules\Products\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Modules\Products\Entities\Product;
use Modules\Products\Repositories\ProductRepository;
use Modules\Products\Transformers\ProductBreifResource;
use Modules\Products\Transformers\ProductResource;
use Modules\Support\Traits\ApiTrait;
use Illuminate\Http\Request;
use Modules\Products\Entities\UserProduct;
use Modules\Products\Transformers\UserProductResource;

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
  public function showuserproduct($id)
{
$userProduct=UserProduct::findorfail($id);

    return $this->sendResponse(new UserProductResource($userProduct), __('Data Found'));
}

    public function store(Request $request)
    {
        $user = auth()->user();
        $data = $request->except('addresses_ids');
        $data['user_id'] = $user->id;

        $userProduct = $this->repository->create($data);
        if (!empty($data['addresses']) && is_array($data['addresses'])) {
            foreach ($data['addresses'] as $address) {
                $userProduct->addresses()->attach($address['id'], [
                    'latitude' => $address['lat'] ?? null,
                    'longitude' => $address['long'] ?? null,
                ]);
            }
        }

        $userProduct->load('addresses', 'media');

        return response()->json([
            'message' => 'User Product created successfully',
            'data' => $userProduct
        ]);
    }
}
