<?php

namespace Modules\Orders\Http\Requests;

use App\Enums\OrderStatusEnum;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\Support\Traits\ApiTrait;

class CompleteOrderRequest extends FormRequest
{
    use ApiTrait;
    /**
     * @return array
     */
    public function rules()
    {
        return [];
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

    public function withValidator(Validator $validator)
    {
        if ($validator->errors()->count() > 0) {
            throw new HttpResponseException($this->sendErrorData($validator->errors(), "The given data was invalid."));
        }

        $validator->after(function ($validator) {

            if ($this->order->status == OrderStatusEnum::Completed->value) {
                $message = trans("orders::validation.this order is already :status", ["status" => OrderStatusEnum::translatedName($this->order->status)]);
                throw new HttpResponseException($this->sendErrorData(["error" => [$message]], "The given data was invalid."));
            }
            if ($this->order->worker_id != auth()->id()) {
                $message = trans("orders::validation.the worker who responsable for this order only can make it complete .");
                throw new HttpResponseException($this->sendErrorData(["error" => [$message]], "The given data was invalid."));
            }
        });
    }



    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return RuleFactory::make(trans('orders::orders.attributes'));
    }
}
