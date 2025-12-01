<?php

namespace Modules\Orders\Http\Requests;

use App\Enums\OrderStatusEnum;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Laraeast\LaravelSettings\Facades\Settings;
use Modules\Support\Traits\ApiTrait;

class PayOrderRequest extends FormRequest
{
    use ApiTrait;
    /**
     * @return array
     */
    public function rules()
    {
        $shouldHavePayment = $this->order->orderAdditions()->sum('total') > 0;
        $hasElectronicPayment = in_array(3, collect($this->payments)->pluck('payment_id')->toArray());

        return [
            'payments'              => [$shouldHavePayment ? 'required' : 'sometimes', 'array'],

            'payments.*.payment_id' => ['sometimes', 'exists:payments,id'],
            'payments.*.payment'    => ['sometimes', 'numeric'],

            'user_package_id'       => ['sometimes', 'exists:user_packages,id,user_id,' . auth()->id()],
            'is_reward'             => ['required', 'boolean'],

            'invoice_id'            => [$hasElectronicPayment ? 'required' : 'nullable', 'unique:orders,invoice_id,' . $this->order->id],
            'payment_id'            => [$hasElectronicPayment ? 'required' : 'nullable', 'unique:orders,payment_id'],
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
            throw new HttpResponseException($this->sendErrorData($validator->errors(), 'The given data was invalid.'));
        }

        $validator->after(function ($validator) {

            if ($this->order->status == OrderStatusEnum::Paid->value) {
                $message = trans('orders::validation.this order is already :status', ['status' => OrderStatusEnum::translatedName($this->order->status)]);
                throw new HttpResponseException($this->sendErrorData(['error' => [$message]], 'The given data was invalid.'));
            }

            // check package
            $this->checkPackage();


            // check Reward
            $this->checkReward();


            // check payment
            $this->checkPayment();
        });
    }


    private function checkPackage()
    {
        if ($this->user_package_id) {

            if ($this->is_reward) {
                $message = trans('orders::validation.cant with package and reward together');
                throw new HttpResponseException($this->sendErrorData(['error' => [$message]], 'The given data was invalid.'));
            }

            $userPackage = auth()->user()->userPackages()
                ->whereId($this->user_package_id)
                ->first();
            $validations = [
                $userPackage->vendor->id            == $this->order->vendor_id  ? false : trans('orders::validation.this package doesnt belong to this vendor'),    // applicable For Vendor
                $userPackage->package->size_id      == $this->order->size_id    ? false : trans('orders::validation.this package doesnt belong to this size'),      // applicable For Size
                $userPackage->package->service_id   == $this->order->service_id ? false : trans('orders::validation.this package doesnt belong to this service'),   // applicable For Service
                !$userPackage->isExpired                                        ? false : trans('orders::validation.this package is expired'),                      // isExpired
            ];

            foreach ($validations as $validation) {
                if ($validation) {
                    throw new HttpResponseException($this->sendErrorData(['error' => [$validation]], 'The given data was invalid.'));
                }
            }
        }
    }

    private function checkReward()
    {
        if ($this->is_reward) {
            $rewardCount = Settings::get('reward_count');
            $reward = auth()->user()->orders()->applicableReward($this->order)->count() < $rewardCount;
            if ($reward) {
                $message = trans('orders::validation.you dont have enough reward points');
                throw new HttpResponseException($this->sendErrorData(['error' => [$message]], 'The given data was invalid.'));
            }
        }
    }


    private function checkPayment()
    {
        if ($this->payments) {

            // only case that has more than one payment
            // if pays by wallet and rest of the money by other payment method
            // otherwise is resticted
            if (count($this->payments) > 1) {
                $check = in_array(1, collect($this->payments)->pluck('payment_id')->toArray());

                if (!$check) {
                    $message = trans('orders::validation.cant pay with these two payment method together');
                    throw new HttpResponseException($this->sendErrorData(['error' => [$message]], 'The given data was invalid.'));
                }
            }


            $WalletPaymentIndex = array_search('1', array_column($this->payments, 'payment_id'));

            if (is_numeric($WalletPaymentIndex)) {

                $paidWithWallet =  $this->payments[$WalletPaymentIndex]['payment'];
                if ($paidWithWallet > $this->order->user->balance) {
                    $message = trans('orders::validation.user balance not enough');
                    throw new HttpResponseException($this->sendErrorData(['error' => [$message]], 'The given data was invalid.'));
                }
            }

            $servicePrice = $this->user_package_id || $this->is_reward ? $this->order->service_price : 0;
            $shouldBePaid = $this->order->total - ($servicePrice * (1 + ($this->order->orderTaxes()->sum('percentage') / 100)));

            // paid money should be equal the price //
            $moneyPaid = array_sum(collect($this->payments)->pluck('payment')->toArray());

            if ($moneyPaid != $shouldBePaid) {
                $message = trans('orders::validation.the paid money doesnt equal the required to pay , you should pay :total', ['total' => $shouldBePaid]);
                throw new HttpResponseException($this->sendErrorData(['error' => [$message]], 'The given data was invalid.'));
            }
        }
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
