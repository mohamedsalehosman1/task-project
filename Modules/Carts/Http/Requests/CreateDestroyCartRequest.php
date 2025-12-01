<?php

namespace Modules\Carts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDestroyCartRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'products' => ['required', 'array','min:1'],
            'products.*' => ['exists:products,id'],
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
}
