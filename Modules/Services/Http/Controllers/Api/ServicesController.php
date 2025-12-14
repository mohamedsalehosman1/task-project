<?php

namespace Modules\Services\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Modules\Carts\Entities\CartItem;
use Modules\Products\Transformers\ProductBreifResource;
use Modules\Services\Entities\Service;
use Modules\Services\Http\Filters\ServiceFilter;
use Modules\Services\Transformers\ServiceBriefResource;
use Modules\Services\Transformers\ServiceResource;
use Modules\Support\Traits\ApiTrait;

class ServicesController extends Controller
{
    use ApiTrait;

    private $filter;

    /**
     * ServiceFilter constructor.
     */


    public function __construct(ServiceFilter $filter)
    {
        $this->filter = $filter;
    }


    /**
     * Display a listing of the services.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function index()
    {
        $data = Service::filter($this->filter)->get();
        return $this->sendResponse(ServiceBriefResource::collection($data), 'success');
    }

    /**
     * Show the specified resource.
     *
     * @param  Service $service
     * @return \Illuminate\Http\JsonResponse
     */

public function show($id)
{
    $service = Service::with([
        'products' => function ($query) {
            $query->where('status', 'accepeted')->where('active', true);
        },
        'userproducts' => function ($query) {
            $query->where('status', 'accepeted')->where('available', true);
        },
    ])->findOrFail($id);

    $user = auth('sanctum')->user();

    // اجمع كل عناصر السلة Morph مرة واحدة
    $cartItems = collect();

    if ($user && $user->cart) {
        $cartItems = CartItem::where('cart_id', $user->cart->id)->get();
    }

    $productsArray = collect();

    // منتجات لوحة التحكم
    foreach ($service->products as $product) {

        $productsArray->push([
            'id' => $product->id,
            'product_id' => $product->id,
            'user_product_id' => null,
            'name' => $product->name ?? '',
'in_cart' => $cartItems->contains('product_id', $product->id),
            'company_name' => $product->company_name ?? '',
            'region' => optional($product->region)->name,
            'old_price' => (float) ($product->old_price ?? 0),
            'price' => (float) ($product->price ?? 0),
            'image' => $product->cover ?? '',
        ]);
    }

    // منتجات التطبيق UserProduct
    foreach ($service->userproducts as $userProduct) {

        $inCart = $cartItems->contains(function ($item) use ($userProduct) {
            return $item->cartable_type === \Modules\Products\Entities\UserProduct::class &&
                   $item->cartable_id == $userProduct->id;
        });

        $productsArray->push([
            'id' => $userProduct->id,
            'product_id' => null,
            'user_product_id' => $userProduct->id,
            'name' => $userProduct->name ?? '',
            'in_cart' => $inCart,
            'company_name' => $userProduct->company_name ?? '',
            'region' => optional($userProduct->region)->name,
            'old_price' => (float) ($userProduct->old_price ?? 0),
            'price' => (float) ($userProduct->price ?? 0),
            'image' => $userProduct->cover ?? '',
        ]);
    }

    return $this->sendResponse([
        'id' => $service->id,
        'name' => $service->name,
        'products' => $productsArray->values(),
    ], __('تم العثور على البيانات'));
}



}
