<?php

namespace Modules\Orders\Http\Requests;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Validator;
use Modules\Carts\Entities\CartItem;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\ProductVariance;
use Modules\Services\Entities\Service;
use Modules\Support\Traits\ApiTrait;

class OrderRequest extends FormRequest
{
    use ApiTrait;
    /**
     * @return array
     */
  public function rules()
{
    return [
        'payment_id'   => ['required'],
        // 'address_id'   => ['required', 'exists:addresses,id,user_id,' . auth()->id()],
        'coupon_code'  => ['nullable', 'exists:coupons,code'],

        // المنتجات
        'products'            => ['required', 'array', 'min:1'],

        'products.*.id'        => ['required', 'exists:products,id,deleted_at,NULL'],
        'products.*.quantity'  => ['required', 'integer', 'min:1'],
        'products.*.price'     => ['required', 'numeric', 'min:0'],
        'products.*.latitude'  => ['nullable', 'numeric', 'between:-90,90'],
        'products.*.longitude' => ['nullable', 'numeric', 'between:-180,180'],
        'products.*.delivery_date' => ['nullable', 'date'],
        'products.*.delivery_time' => ['nullable', 'string'],
        'products.*.notes'         => ['nullable', 'string', 'max:255'],
    ];
}


    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $user = auth()->user();
                 $cartItems = CartItem::where('cart_id', $user->cart->id)
                                    ->where('product_id', $this->products)
                                    ->get();
            if ($cartItems->isEmpty()) {
                $validator->errors()->add('products', 'Selected items are not in your cart.');
                return;
            }

            // $deletedProducts = Product::onlyTrashed()
            //     ->whereIn('id', $this->products)
            //     ->get();

            // if ($deletedProducts->count() > 0) {
            //     $product = $deletedProducts->first()->name;
            //     $validator->errors()->add('product_variances', "Please remove the product '{$product}' from the basket because it's not valid.");
            // }
        });
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


}
