<?php

namespace Modules\Vendors\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Accounts\Entities\Verification;
use Modules\Accounts\Events\VerificationCreated;
use Modules\Vendors\Http\Requests\Api\VerificationRequest;
use Modules\Vendors\Http\Requests\Api\VerifyRequest;
use Modules\Support\Traits\ApiTrait;
use Modules\Vendors\Entities\Vendor;

class VerificationController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, ApiTrait;

    /**
     * Send or resend the verification code.
     *
     * @param VerifyRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function send(VerifyRequest $request): JsonResponse
    {
        $vendor = Vendor::wherePhone($request->phone)->first();

        if (!$vendor) {
            return $this->sendError(trans('accounts::auth.failed'));
        }

        $verification = Verification::updateOrCreate([
            'parentable_id' => $vendor->id,
            'parentable_type' => $vendor->getMorphClass(),
            'username' => $request->phone,
        ], [
            'code' => random_int(1111, 9999),
        ]);


        if (env("SMS_LIVE_MODE")) {
            event(new VerificationCreated($verification));
        }

        return response()->json([
            'code' => $verification->code,
            'message' => trans('accounts::verification.sent'),
        ]);
    }

    /**
     * Verify the user's phone number.
     *
     * @param VerificationRequest $request
     * @return JsonResponse
     */
    public function verify(VerificationRequest $request): JsonResponse
    {
        $vendor = Vendor::wherePhone($request->phone)->first();

        if (!$vendor) {
            return $this->sendError(trans('accounts::auth.failed'));
        }

        $verification = Verification::where([
            'parentable_id' => $vendor->id,
            'parentable_type' => $vendor->getMorphClass(),
            'code' => $request->code,
        ])->first();

        if (!$verification || $verification->isExpired()) {
            return $this->sendError(trans('accounts::verification.invalid'));
        }

        $vendor->forceFill([
            'phone' => $verification->username,
            'phone_verified_at' => now(),
        ])->save();

        $verification->delete();

        $data = $vendor->getResource();
        $data['token'] = $vendor->createTokenForDevice($request->device_name);
        return $this->sendResponse($data, trans('accounts::verification.is_verified'));
    }
}
