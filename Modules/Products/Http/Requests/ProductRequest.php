<?php

namespace Modules\Products\Http\Requests;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            '%name%' => ['required', 'string', 'max:255'],
            // '%description%' => ['required'],

            "service_id" => ['required', 'exists:services,id'],
            "vendor_id" => ['required', 'exists:vendors,id'],

            "made_in" => ['required', 'string'],
            // "material" => ['required', 'array'],
            // "material.*.material" => ['required', 'string'],

            'price' => ['required', 'numeric', 'min:.01'],
            'old_price' => ['required', 'lt:price'],

            'cover' => ['required', 'mimes:jpeg,jpg,png', 'max:10000'],
            'images' => ['required', 'array'],
            'images.*' => ['required', 'mimes:jpeg,jpg,png', 'max:10000'],
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
            '%name%' => ['required', 'string', 'max:255'],
            '%description%' => ['required', 'string'],

            "service_id" => ['required', 'exists:services,id'],
            "vendor_id" => ['required', 'exists:vendors,id'],

            "made_in" => ['required', 'string'],
            "material" => ['required', 'array'],
            "material.*.material" => ['required', 'string'],

            'price' => ['required', 'numeric', 'min:.01'],
            'old_price' => ['required', 'numeric', 'min:.01', 'gt:price'],

            'cover' => ['nullable', 'mimes:jpeg,jpg,png', 'max:10000'],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'mimes:jpeg,jpg,png', 'max:10000'],
        ]);
    }

    // to do

    // $service_ids = array_diff($product->services->pluck('id')->toArray(), $data['service']);

    // $productsIsUsedByVendors = Price::whereProductId($product->id)->whereHas('vendorService' , fn($q) => $q->whereIn('service_id' , $service_ids))->get() ;

    // dd($productsIsUsedByVendors);

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
