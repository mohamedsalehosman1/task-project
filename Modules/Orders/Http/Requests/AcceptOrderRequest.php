<?php

namespace Modules\Orders\Http\Requests;

use App\Enums\OrderStatusEnum;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\Support\Traits\ApiTrait;

class AcceptOrderRequest extends FormRequest
{
    use ApiTrait;
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'vehicle_number' => ['sometimes', 'numeric'],
            'vehicle_letter' => ['sometimes', 'string']
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

    public function withValidator(Validator $validator)
    {
        if ($validator->errors()->count() > 0) {
            throw new HttpResponseException($this->sendErrorData($validator->errors(), "The given data was invalid."));
        }

        $validator->after(function ($validator) {

            if (!in_array(auth()->id(), $this->order->vendor->workers->pluck("id")->toArray())) {
                $message = trans("orders::validation.this worker is belong to vendor", ["vendor" => $this->order->vendor->name]);
                throw new HttpResponseException($this->sendErrorData(["error" => [$message]], $message));
            }

            if ($this->order->status == OrderStatusEnum::Accepted->value) {
                $message = trans("orders::validation.this order is already :status", ["status" => OrderStatusEnum::translatedName($this->order->status)]);
                throw new HttpResponseException($this->sendErrorData(["error" => [$message]], $message));
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
