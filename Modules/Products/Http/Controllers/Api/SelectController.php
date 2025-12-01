<?php

namespace Modules\Products\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Modules\Products\Entities\Product;
use Modules\Products\Transformers\ProductSelectResource;
use Modules\Support\Traits\ApiTrait;

class SelectController extends Controller
{
    use ApiTrait;

    public function vendorProducts($id)
    {
        $products = Product::where('vendor_id', $id)->get();
        return $this->sendResponse(ProductSelectResource::collection($products), __('Data Found'));
    }

}
