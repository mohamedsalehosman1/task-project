<?php

namespace Modules\Products\Http\Requests;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class ProductVarianceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('POST')) {
            return $this->createRules();
        } else {
            return $this->updateRules();
        }
    }

    /**
     * Get the create validation rules that apply to the request.
     *
     * @return array
     */
    public function createRules()
    {
        return RuleFactory::make([
            "size_id" => ['sometimes', 'exists:sizes,id'],
            "product_id" => ['required', 'exists:products,id'],

            'colors' => ['required', 'array'],
            'colors.*' => ['required', 'exists:colors,id'],

            'quantity' => ['required', 'array'],
            'quantity.*' => ['required', 'numeric'],
        ]);
    }

    /**
     * Get the update validation rules that apply to the request.
     *
     * @return array
     */
    public function updateRules()
    {
        return RuleFactory::make([
            "size_id" => ['required', 'exists:sizes,id'],
            "product_id" => ['required', 'exists:products,id'],

            'colors' => ['required', 'array'],
            'colors.*' => ['required', 'exists:colors,id'],

            'quantity' => ['required', 'array'],
            'quantity.*' => ['required', 'numeric'],
        ]);
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return RuleFactory::make(trans('products::products.attributes'));
    }
}
