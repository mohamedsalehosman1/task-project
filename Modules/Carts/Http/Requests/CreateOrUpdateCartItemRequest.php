<?php

namespace Modules\Carts\Http\Requests;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\ProductVariance;

class CreateOrUpdateCartItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $max_quantity = Product::find($this->product_id)?->max_quantity;

        return [
            'product_id' => 'required|exists:products,id,deleted_at,NULL',
            'quantity' => "required|numeric|min:1|min:$max_quantity",
        ];
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

    public function attributes()
    {
        return RuleFactory::make(trans('carts::carts.attributes'));
    }
}
