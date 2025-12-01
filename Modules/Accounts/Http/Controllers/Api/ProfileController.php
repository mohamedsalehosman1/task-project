<?php

namespace Modules\Accounts\Http\Controllers\Api;

use Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Accounts\Entities\User;
use Modules\Accounts\Entities\Verification;
use Modules\Accounts\Http\Requests\Api\PhoneRequest;
use Modules\Accounts\Http\Requests\Api\ProfileRequest;
use Modules\Accounts\Http\Requests\Api\VerifyPhoneRequest;
use Modules\Accounts\Transformers\CustomerResource;
use Modules\Support\Traits\ApiTrait;

class ProfileController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, ApiTrait;
 /**
     * Handle a login request to the application.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function getResource(User $user)
{
    return new CustomerResource($user);
}

    public function __construct()
    {
        $this->middleware('isUser');
    }

    /**
     * Display the authenticated user resource.
     *
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        $user = auth()->user();

        if (!$user) {
            return $this->sendError(trans('accounts::auth.failed'));
        }
        $data = $this->getResource($user);
        return $this->sendResponse($data, 'success');
    }

    /**
     * Update the authenticated user profile.
     *
     * @param ProfileRequest $request
     * @return JsonResponse
     */
    public function update(ProfileRequest $request)
    {
        $user = auth()->user();
        if (!$user) {
            return $this->sendError(trans('accounts::auth.failed'));
        }

        $user->update($request->except('password'));

        if ($request->hasFile('avatar')) {
            $user->clearMediaCollection('avatars'); // لو حابب تحذف القديم
            $user->addMediaFromRequest('avatar')
                ->usingFileName('avatar_' . time() . '.' . $request->file('avatar')->getClientOriginalExtension())
                ->toMediaCollection('avatars');
        }


        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        $data = $this->getResource($user);
        return $this->sendResponse($data, 'success');
    }

    /**
     * @return JsonResponse
     */
    public function exist(): JsonResponse
    {
        $user = auth()->user();
        if (!$user->exists()) {
            return $this->sendError(trans('accounts::auth.failed'));
        }

        $data = $user->getResource();
        return $this->sendResponse($data, 'success');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function preferredLocale(Request $request): JsonResponse
    {
        $user = auth()->user();

        $user->preferred_locale = $request->preferred_locale;

        $user->push();

        $data = $user->getResource();
        return $this->sendResponse($data, 'success');
    }

    public function logout(Request $request)
    {
        $user = auth()->user();
        //remove device token
        $user->update([
            'device_token' => null
        ]);

        $user->tokens()->delete();
        return $this->sendSuccess(__('You Have Signed Out Successfully'));
    }


    public function delete(Request $request)
    {
        $user = $request->user();

        if (!Hash::check($request->password, $user->password)) {
            return $this->sendError(trans('accounts::users.messages.password'));
        }

        $user->forceDelete();

        return $this->sendSuccess(trans('accounts::users.messages.request_delete'));
    }


    /**
     * @return JsonResponse
     */
    public function check(): JsonResponse
    {
        $user = auth()->user();

        if (!$user) {
            return $this->sendError('false');
        } else {
            return $this->sendSuccess('true');
        }
    }

    public function updatePhone(PhoneRequest $request)
    {
        $user = User::find(auth()->user()->id);

        $verification = Verification::updateOrCreate([
            'parentable_id' => $user->id,
            'parentable_type' => $user->getMorphClass(),
            'username' => $request->new,
        ], [
            'code' => random_int(1111, 9999),
        ]);

        if (env("SMS_LIVE_MODE")) {
            $user->sendSmsVerificationNotification($request->new, $verification->code);
        }

        $data = [
            'code' => $verification->code,
        ];

        return $this->sendResponse($data, trans('accounts::verification.sent'));
    }

    public function verifyPhone(VerifyPhoneRequest $request)
    {
        $user = User::find(auth()->user()->id);

        $verification = Verification::where([
            'parentable_id' => $user->id,
            'parentable_type' => $user->getMorphClass(),
            'code' => $request->code,
            'username' => $request->new,
        ])->first();

        if (!$verification || $verification->isExpired()) {
            return $this->sendError(trans('accounts::verification.invalid'));
        }

        $user->forceFill([
            'phone' => $verification->username,
        ])->save();

        $verification->delete();

        $data = $user->getResource();

        return $this->sendResponse($data, __('Phone updated successfully.'));
    }


    public function updateFcm(Request $request)
    {
        $user = auth()->user();
        $user->update($request->only('device_token', "order_notification"));
        $data = $user->getResource();
        return $this->sendResponse($data, 'success');
    }

    public function updateLocation(Request $request)
{
   $request->validate([
    'region_id'  => 'required|exists:regions,id',
    'address_id' => 'required|exists:addresses,id',
]);


    $user = auth()->user();

    if (!$user) {
        return $this->sendError(trans('accounts::auth.failed'));
    }

    $user->update([
        'region_id' => $request->region_id,
        'address_id' => $request->address_id,
    ]);

    $data = $this->getResource($user);

    return $this->sendResponse($data, __('Location updated successfully.'));
}

}
