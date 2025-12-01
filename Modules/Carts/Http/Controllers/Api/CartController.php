<?php

namespace Modules\Carts\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Modules\Carts\Http\Requests\CreateDestroyCartRequest;
use Modules\Carts\Http\Requests\CreateOrUpdateCartItemRequest;
use Modules\Carts\Repositories\CartRepository;
use Modules\Carts\Transformers\CartResource;
use Modules\Products\Entities\ProductVariance;
use Modules\Support\Traits\ApiTrait;

class CartController extends Controller
{
    use ApiTrait;

    protected $repository;


    public function __construct(CartRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $data  = $this->repository->setUser(auth()->user())->all();

        return $this->sendResponse(new CartResource($data), __('Data Found'));
    }


    public function store(CreateOrUpdateCartItemRequest $request)
    {
        $cart = $this->repository->setUser(auth()->user())->create($request->validated());
        return $this->sendResponse(new CartResource($cart), __('Data Found'));
    }

    public function destroy(CreateDestroyCartRequest $request)
    {
        $cart = $this->repository->setUser(auth()->user())->delete($request->validated()['products']);

        return $this->sendResponse(new CartResource($cart), __('Data Found'));
    }

    public function destroyAllCart()
    {
        $cart =  $this->repository->setUser(auth()->user())->destroyAllCart();

        return $this->sendResponse(new CartResource($cart), __('Data Found'));
    }
}
