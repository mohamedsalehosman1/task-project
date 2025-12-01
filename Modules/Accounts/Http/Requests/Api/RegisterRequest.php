<?php

namespace Modules\Accounts\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Modules\Accounts\Http\Requests\WithHashedPassword;
use Modules\Support\Traits\ApiTrait;

class RegisterRequest extends FormRequest
{
    use WithHashedPassword, ApiTrait;

    /**
     * Determine if the supervisor is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
'phone' => ['required', 'unique:users,phone', 'regex:/^05[0-9]{8}$/', 'digits:10'],
            'password' => ['required', 'confirmed', 'min:6'],
            'email' => ['nullable', 'unique:users,email'],
            'device_token' => ['required'],
            'preferred_locale' => 'required|in:ar,en',
            // 'code' => ['required'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return trans('accounts::user.attributes');
    }

    /**
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        // $response = $this->sendErrorData($validator->errors()->toArray(), 'fail');
        $response = $this->sendError($validator->errors()->toArray());

        throw new ValidationException($validator, $response);
    }
}
