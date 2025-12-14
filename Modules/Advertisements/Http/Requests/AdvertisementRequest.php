<?php

namespace Modules\Advertisements\Http\Requests;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class AdvertisementRequest extends FormRequest
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
        $data = [
            'title:ar' => ['required', 'string', 'max:255'],
                        'title:en' => ['required', 'string', 'max:255'],

            'description:ar' => ['required', 'string'],
                        'description:en' => ['required', 'string'],

            'image' => 'required', 'mimes:jpeg,jpg,png', 'max:1000',
            'vendor_id' => ['nullable', 'exists:vendors,id'],
        ];
        if (request('defined') == 1) {
            $data['start_at'] = ['required_if:defined,1', 'after_or_equal:' . date('Y-m-d')];
            $data['end_at'] = ['required_if:defined,1', 'after:start_at'];
        }
        return RuleFactory::make($data);
    }

    /**
     * Get the update validation rules that apply to the request.
     *
     * @return array
     */
    public function updateRules()
    {
        $data = [
            'title:ar' => ['required', 'string', 'max:255'],
                        'title:en' => ['required', 'string', 'max:255'],

            'description:ar' => ['required', 'string'],
                        'description:en' => ['required', 'string'],
            'image' => 'nullable', 'mimes:jpeg,jpg,png', 'max:1000',
            'vendor_id' => ['nullable', 'exists:vendors,id'],
        ];
        if (request('defined') == 1) {
            $data['start_at'] = ['required_if:defined,1', 'after_or_equal:' . date('Y-m-d')];
            $data['end_at'] = ['required_if:defined,1', 'after:start_at'];
        }
        return RuleFactory::make($data);
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return trans('advertisements::advertisements.attributes');
    }
}
