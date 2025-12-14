<?php

namespace Modules\Vendors\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Astrotomic\Translatable\Validation\RuleFactory;

class VendorRequest extends FormRequest
{
    use WithHashedPassword;

    /**
     * Determine if the supervisor is authorized to make this request.
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
           'name:ar' => ['required', 'string', 'max:255'],
                        'name:en' => ['required', 'string', 'max:255'],
            'description:en' => ['required', 'string'],

            'description:ar' => ['required', 'string'],
            'email' => ['required', 'unique:vendors,email', 'unique:users,email'],
            'phone' => ['required', 'unique:vendors,phone', 'unique:users,phone', "numeric"],
            'password' => ['required', 'min:8', 'confirmed'],
           'image' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:1000'],
'banners' => ['required', 'array'],
'banners.*' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:1000'],

            "lat" => ['required'],
            "long" => ['required'],
            "address" => ['required', 'string'],
        ]);
    }

    /**
     * Get the update validation rules that apply to the request.
     *
     * @return array
     */
    public function updateRules()
    {
        $vendor = $this->route('vendor') ?? auth()->user()->vendor;
        $user = $vendor->admin;

        return RuleFactory::make([
            'name:ar' => ['required', 'string', 'max:255'],
                        'name:en' => ['required', 'string', 'max:255'],
            'description:en' => ['required', 'string'],

            'description:ar' => ['required', 'string'],
            'email' => ['required', 'unique:vendors,email,' . $vendor->id, 'unique:users,email,' . $user->id],
            'phone' => ['required', "numeric", 'unique:vendors,phone,' . $vendor->id, 'unique:users,phone,' . $user->id],
            'password' => ['nullable', 'min:8', 'confirmed'],
            'image' => ['nullable', 'mimes:jpeg,jpg,png', 'max:1000'],
            'banners' => ['nullable', "array"],
            'banners.*' => ['nullable', 'mimes:jpeg,jpg,png', 'max:1000'],
            "lat" => ['required'],
            "long" => ['required'],
            "address" => ['required', 'string'],
        ]);
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return trans('vendors::vendors.attributes');
    }
}
