<?php

namespace Modules\Accounts\Http\Requests\Api;

use App\Enums\AddressTypesEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;
use Modules\Support\Traits\ApiTrait;

class AddressesApiRequest extends FormRequest
{
    use ApiTrait;

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
        return [
            'building_number' => ['nullable', 'string', 'max:3'],
            'appartement_number' => ['nullable', 'string', 'max:3'],
            'floor_number' => ['nullable', 'string' , 'max:3'],
            'street_name' => ['required', 'string'],
            'landmark' => ['nullable', 'string'],
            'area' => ['nullable', 'string'],
            'lat' => ['required', 'string'],
            'long' => ['required', 'string'],
            'type' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return trans('addresses::addresses.attributes');
    }

    /**
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = $this->sendErrorData($validator->errors()->toArray(), 'fail');

        throw new ValidationException($validator, $response);
    }
}
