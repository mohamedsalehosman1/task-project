<?php

namespace Modules\Products\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->isMethod('POST')) {
            return $this->createRules();
        } else {
            return $this->updateRules();
        }
    }

    /**
     * قواعد إنشاء المنتج الجديد
     */
    public function createRules()
    {
        return [
            'name.*'               => 'required|string|max:255',
            'company_name'         => 'nullable|array',
            'description'          => 'nullable|array',
            'vendor_id'            => 'required|integer|exists:vendors,id',
            'service_id'           => 'required|integer|exists:services,id',
            'old_price'            => 'nullable|numeric',
            'price'                => 'required|numeric',
            'pay_type'            => 'nullable|in:in_app,out_app',
            'has_quantity_limit'   => 'nullable|boolean',
            'max_amount'           => 'nullable|integer|min:0|required_if:has_quantity_limit,1',
            'base_preparation_time'=> 'nullable|string',
            'region_id'            => 'nullable|integer|exists:regions,id',
            'addresses_ids'        => 'nullable|array',
            'addresses_ids.*'      => 'integer|exists:addresses,id',
            'enable_working_hours' => 'nullable|boolean',

            // Working hours (optional)
            'working_hours.day'    => 'nullable|array',
            'working_hours.from'   => 'nullable|array',
            'working_hours.to'     => 'nullable|array',
        ];
    }


    public function updateRules()
    {
        return [
            'name.*'               => 'required|string|max:255',
            'company_name'         => 'nullable|array',
            'description'          => 'nullable|array',
            'vendor_id'            => 'required|integer|exists:vendors,id',
            'service_id'           => 'required|integer|exists:services,id',
            'old_price'            => 'nullable|numeric',
            'price'                => 'required|numeric',
            'has_quantity_limit'   => 'nullable|boolean',
            'max_amount'           => 'nullable|integer|min:0|required_if:has_quantity_limit,1',
            'base_preparation_time'=> 'nullable|string',
            'region_id'            => 'nullable|integer|exists:regions,id',
            'addresses_ids'        => 'nullable|array',
            'addresses_ids.*'      => 'integer|exists:addresses,id',
            'enable_working_hours' => 'nullable|boolean',
'active'=>'nullable|boolean',
            // Working hours
            'working_hours.day'    => 'nullable|array',
            'working_hours.from'   => 'nullable|array',
            'working_hours.to'     => 'nullable|array',
        ];
    }

    public function attributes()
    {
        return [
            'name.*'               => trans('products::products.attributes.name'),
            'price'                => trans('products::products.attributes.price'),
            'old_price'            => trans('products::products.attributes.old_price'),
            'vendor_id'            => trans('products::products.attributes.vendor_id'),
            'service_id'           => trans('products::products.attributes.service_id'),
            'region_id'            => trans('products::products.attributes.region_id'),
            'addresses_ids'        => trans('products::products.attributes.addresses'),
            'has_quantity_limit'   => trans('products::products.attributes.has_quantity_limit'),
            'max_amount'           => trans('products::products.attributes.max_amount'),
            'enable_working_hours' => trans('products::products.attributes.enable_working_hours'),
        ];
    }
}
