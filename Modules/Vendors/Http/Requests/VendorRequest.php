<?php
namespace Modules\Vendors\Http\Requests;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

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
            '%name%'                         => ['required', 'string', 'max:255'],
            '%description%'                  => ['required', 'string'],
            '%nationality%'                  => ['required', 'string'],
            'identity_number'                => [
                'required',
                'unique:vendors,identity_number',
                'numeric',
                'regex:/^[12][0-9]{9}$/',
            ],
            'commercial_registration_number' => [
                'required',
                'unique:vendors,commercial_registration_number',
                'numeric',
                'digits:10',
            ],

            'email'                          => ['required', 'unique:vendors,email', 'unique:users,email'],
            'phone'                          => [
                'required',
                'unique:vendors,phone',
                'unique:users,phone',
                'numeric',
                'regex:/^(009665|9665|\+9665|05)[0-9]{8}$/',
            ],
            'password'                       => ['required', 'min:8', 'confirmed'],
            'image'                          => ['required', 'mimes:jpeg,jpg,png', 'max:4000'],
            'banners'                        => ['required', 'array'],
            'banners.*'                      => ['required', 'mimes:jpeg,jpg,png', 'max:4000'],
            "lat"                            => ['required'],
            "long"                           => ['required'],
            "address"                        => ['required', 'string'],
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
        $user   = $vendor->admin;

        return RuleFactory::make([
            '%name%'        => ['required', 'string', 'max:255'],
            '%description%' => ['required', 'string'],
            'email'         => ['required', 'unique:vendors,email,' . $vendor->id, 'unique:users,email,' . $user->id],
            'phone'         => ['required', "numeric", 'unique:vendors,phone,' . $vendor->id, 'unique:users,phone,' . $user->id],
            'password'      => ['nullable', 'min:8', 'confirmed'],
            'image'         => ['nullable', 'mimes:jpeg,jpg,png', 'max:1000'],
            'banners'       => ['nullable', "array"],
            'banners.*'     => ['nullable', 'mimes:jpeg,jpg,png', 'max:1000'],
            "lat"           => ['required'],
            "long"          => ['required'],
            "address"       => ['required', 'string'],
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
