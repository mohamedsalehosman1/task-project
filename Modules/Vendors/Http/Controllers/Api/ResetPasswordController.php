<?php

namespace Modules\Vendors\Http\Controllers\Api;

use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Accounts\Entities\ResetPasswordCode;
use Modules\Accounts\Entities\ResetPasswordToken;
use Modules\Accounts\Events\ResetPasswordCreated;
use Modules\Vendors\Http\Requests\Api\ForgetPasswordRequest;
use Modules\Vendors\Http\Requests\Api\ResetPasswordCodeRequest;
use Modules\Vendors\Http\Requests\Api\ResetPasswordRequest;
use Modules\Support\Traits\ApiTrait;
use Modules\Vendors\Entities\Vendor;

class ResetPasswordController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, ApiTrait;

    /**
     * Send forget password code to the vendor.
     *
     * @param ForgetPasswordRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function forget(ForgetPasswordRequest $request): JsonResponse
    {
        $vendor = Vendor::wherePhone($request->phone)->first();

        if (!$vendor) {
            return $this->sendError(trans('vendors::auth.failed'));
        }

        $resetPasswordCode = ResetPasswordCode::updateOrCreate([
            'username' => $request->phone,
            'type' => 'vendor',
        ], [
            'username' => $request->phone,
            'type' => 'vendor',
            'code' => random_int(1000, 9999),
            'created_at' => Carbon::now()
        ]);

        if (env("SMS_LIVE_MODE")) {
            event(new ResetPasswordCreated($resetPasswordCode));
        }

        $data = [
            'reset_code' => $resetPasswordCode->code,
        ];

        return $this->sendResponse($data, trans('vendors::auth.messages.forget-password-code-sent'));
    }

    /**
     * Get the reset password token using verification code.
     *
     * @param ResetPasswordCodeRequest $request
     * @return JsonResponse
     */
    public function code(ResetPasswordCodeRequest $request): JsonResponse
    {
        $resetPasswordCode = ResetPasswordCode::where('username', $request->phone)
            ->where('code', $request->code)
            ->where('type', 'vendor')
            ->first();

        $vendor = Vendor::wherePhone($request->phone)->first();

        if (!$resetPasswordCode || $resetPasswordCode->isExpired() || !$vendor) {
            return $this->sendError(trans('validation.exists', [
                'attribute' => trans('vendors::auth.attributes.code'),
            ]));
        }

        $reset_token = ResetPasswordToken::forceCreate([
            'parentable_id' => $vendor->id,
            'parentable_type' => $vendor->getMorphClass(),
            'token' => $token = Str::random(80),
        ]);

        $data = $vendor->getResource();

        $data['reset_token'] = $reset_token->token;

        return $this->sendResponse($data, 'success');
    }

    /**
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function reset(ResetPasswordRequest $request): JsonResponse
    {
        $resetPasswordToken = ResetPasswordToken::where($request->only('token'))->first();

        if (!$resetPasswordToken || $resetPasswordToken->isExpired()) {
            return $this->sendError(trans('validation.exists', [
                'attribute' => trans('vendors::auth.attributes.token'),
            ]));
        }

        $vendor = $resetPasswordToken->parentable;

        ResetPasswordCode::where('username', $vendor->phone)->where('type', 'vendor')->delete();

        $vendor->update([
            'password' => Hash::make($request->password),
        ]);

        event(new Login('sanctum', $vendor, false));

        $resetPasswordToken->delete();

        $data = $vendor->getResource();

        return $this->sendResponse($data, __('Password updated successfully.'));
    }
}
