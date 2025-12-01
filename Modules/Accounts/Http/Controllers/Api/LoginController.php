<?php

namespace Modules\Accounts\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Accounts\Entities\User;
use Modules\Accounts\Http\Requests\Api\LoginRequest;
use Modules\Interests\Entities\GuestInterest;
use Modules\Support\Traits\ApiTrait;

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
        $user = User::wherePhone($request->phone)->first();

        if (!$user) {
            return $this->sendError(trans('accounts::auth.failed'));
        }

        if ($user->blocked_at) {
            auth()->logout();
            return $this->sendError(trans('accounts::auth.blocked'));
        }

        if (!Hash::check($request->password, $user->password)) {
            return $this->sendError(trans('accounts::users.messages.password'));
        }

        if (!$user->hasVerifiedPhone()) {
            auth()->logout();
            $user->sendVerificationCode(request('test_mode'));
            $data = $user->getResource();
            return $this->sendResponse($data, trans('accounts::users.messages.verified'));
        }

        event(new Login('sanctum', $user, false));

        $user->last_login_at = Carbon::now()->toDateTimeString();
        $user->preferred_locale = $request->preferred_locale ?? app()->getLocale();

        if ($user->device_token === null || $user->device_token != $request->device_token) {
            $user->device_token = $request->device_token;
        }

        $user->push();
// if ($request->device_token) {
//     GuestInterest::syncGuestInterestsToUser($user, $request->device_token);
// }

        $response = [
            'success' => true,
            'data' => $user->getResource(),
            'token' => $user->createToken('MyApp')->plainTextToken,
            'message' => 'success',
        ];

        return response()->json($response);
    }

    public function unauthenticated()
    {
        return $this->sendError(__('You are unauthenticated, please login'));
    }
}
