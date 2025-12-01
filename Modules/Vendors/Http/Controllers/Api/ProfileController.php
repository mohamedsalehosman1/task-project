<?php

namespace Modules\Vendors\Http\Controllers\Api;

use Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Accounts\Entities\Verification;
use Modules\Vendors\Http\Requests\Api\PhoneRequest;
use Modules\Vendors\Http\Requests\Api\ProfileRequest;
use Modules\Vendors\Http\Requests\Api\VerifyPhoneRequest;
use Modules\Support\Traits\ApiTrait;
use Modules\Vendors\Entities\Vendor;
use Modules\Vendors\Http\Requests\Api\LocationRequest;
use Modules\Vendors\Transformers\VendorResource;

class ProfileController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, ApiTrait;

    /**
     * Display the authenticated user resource.
     *
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        $vendor = Vendor::approved()->find(auth()->user()->id);

        if (!$vendor) {
            return $this->sendError(trans('vendors::auth.failed'));
        }
        $data = new VendorResource($vendor);
        return $this->sendResponse($data, 'success');
    }

    /**
     * @param ProfileRequest $request
     * @return JsonResponse
     */
    public function update(ProfileRequest $request)
    {
        $vendor = auth()->user();

        if (!$vendor) {
            return $this->sendError(trans('vendors::auth.failed'));
        }

        $vendor->update($request->except('password'));

        if ($request->avatar && $request->avatar != null) {
            $vendor->addMediaFromBase64($request->avatar)
                ->usingFileName('image.png')
                ->toMediaCollection('images');
        }

        if ($request->password) {
            $vendor->update([
                'password' => Hash::make($request->password),
            ]);
        }

        $data = $vendor->getResource();
        return $this->sendResponse($data, 'success');
    }


    /**
     * @param LocationRequest $request
     * @return JsonResponse
     */
    public function location(LocationRequest $request)
    {
        $vendor = auth()->user();

        if (!$vendor) {
            return $this->sendError(trans('vendors::auth.failed'));
        }

        $vendor->update($request->all());

        $data = $vendor->getResource();
        return $this->sendResponse($data, 'success');
    }

    /**
     * @return JsonResponse
     */
    public function exist(): JsonResponse
    {
        $vendor = auth()->user();
        if (!$vendor->exists()) {
            return $this->sendError(trans('vendors::auth.failed'));
        }

        $data = $vendor->getResource();
        return $this->sendResponse($data, 'success');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function preferredLocale(Request $request): JsonResponse
    {
        $vendor = auth()->user();

        $vendor->preferred_locale = $request->preferred_locale;

        $vendor->push();

        $data = $vendor->getResource();
        return $this->sendResponse($data, 'success');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request) : JsonResponse
    {
        $vendor = auth()->user();
        //remove device token
        $vendor->update([
            'device_token' => null
        ]);

        $vendor->tokens()->delete();
        return $this->sendSuccess(__('You Have Signed Out Successfully'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request) : JsonResponse
    {
        $vendor = $request->user();

        if (!Hash::check($request->password, $vendor->password)) {
            return $this->sendError(trans('vendors::users.messages.password'));
        }

        $vendor->forceDelete();

        return $this->sendSuccess(trans('vendors::users.messages.request_delete'));
    }


    /**
     * @return JsonResponse
     */
    public function check(): JsonResponse
    {
        $vendor = auth()->user();

        if (!$vendor) {
            return $this->sendError('false');
        } else {
            return $this->sendSuccess('true');
        }
    }

    /**
     * @param PhoneRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function updatePhone(PhoneRequest $request)
    {
        $vendor = Vendor::find(auth()->user()->id);

        $verification = Verification::updateOrCreate([
            'parentable_id' => $vendor->id,
            'parentable_type' => $vendor->getMorphClass(),
            'username' => $request->new,
        ], [
            'code' => random_int(1111, 9999),
        ]);

        if (env("SMS_LIVE_MODE")) {
            $vendor->sendSmsVerificationNotification($request->new, $verification->code);
        }

        $data = [
            'code' => $verification->code,
        ];

        return $this->sendResponse($data, trans('vendors::verification.sent'));
    }

    public function verifyPhone(VerifyPhoneRequest $request)
    {
        $vendor = Vendor::find(auth()->user()->id);

        $verification = Verification::where([
            'parentable_id' => $vendor->id,
            'parentable_type' => $vendor->getMorphClass(),
            'code' => $request->code,
            'username' => $request->new,
        ])->first();

        if (!$verification || $verification->isExpired()) {
            return $this->sendError(trans('vendors::verification.invalid'));
        }

        $vendor->forceFill([
            'phone' => $verification->username,
        ])->save();

        $verification->delete();

        $data = $vendor->getResource();

        return $this->sendResponse($data, __('Phone updated successfully.'));
    }
}
