<?php

namespace Modules\Vendors\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Vendors\Entities\Vendor;
use Modules\Support\Traits\ApiTrait;
use Modules\Vendors\Http\Requests\Api\LoginRequest;

class LoginController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, ApiTrait;

    /**
     * Handle a login request to the application.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $vendor = Vendor::wherePhone($request->phone)->first();

        if (!$vendor) {
            return $this->sendError(trans('vendors::auth.failed'));
        }

        if ($vendor->blocked_at) {
            auth()->logout();
            return $this->sendError(trans('vendors::auth.blocked'));
        }

        if (!Hash::check($request->password, $vendor->password)) {
            return $this->sendError(trans('vendors::users.messages.password'));
        }

        if (!$vendor->hasVerifiedPhone()) {
            auth()->logout();
            $vendor->sendVerificationCode(request('test_mode'));
            $data = $vendor->getResource();
            return $this->sendResponse($data, trans('vendors::users.messages.verified'));
        }

        event(new Login('sanctum', $vendor, false));

        $vendor->last_login_at = Carbon::now()->toDateTimeString();
        $vendor->preferred_locale = $request->preferred_locale ?? app()->getLocale();

        if ($vendor->device_token === null || $vendor->device_token != $request->device_token) {
            $vendor->device_token = $request->device_token;
        }

        $vendor->push();

        $data = $vendor->getResource();
        return $this->sendResponse($data, 'success');
    }
}
