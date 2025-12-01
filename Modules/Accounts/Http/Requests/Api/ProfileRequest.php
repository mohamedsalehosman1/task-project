<?php

namespace Modules\Accounts\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Modules\Accounts\Http\Requests\WithHashedPassword;
use Modules\Accounts\Rules\NewPasswordRule;
use Modules\Accounts\Rules\PasswordRule;
use Modules\Support\Traits\ApiTrait;

class ProfileRequest extends FormRequest
{
    use WithHashedPassword, ApiTrait;

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
            'name' => ['nullable', 'string', 'max:255'],
            'phone'=>['nullable','unique:users,phone,' . auth()->id()],
            'email' => ['nullable', 'unique:users,email,' . auth()->id()],
            'old_password' => ['required_with:password', new PasswordRule(auth()->user()->password ?? 'password')],
            'password' => ['nullable', 'min:8', 'confirmed' , new NewPasswordRule($this->old_password)],
            'avatar' => ['nullable', 'image'],
            'location' => ['nullable', 'string'],
            'long' => ['nullable', 'string'],
            'lat' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return trans('accounts::user.attributes');
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
