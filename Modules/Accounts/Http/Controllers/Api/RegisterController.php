<?php

namespace Modules\Accounts\Http\Controllers\Api;

use App\Events\OtpRegister;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Modules\Accounts\Entities\User;
use Modules\Accounts\Http\Requests\Api\RegisterRequest;
use Modules\Accounts\Http\Requests\Api\VerificationRequest;
use Modules\Support\Traits\ApiTrait;

class RegisterController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, ApiTrait;

    /**
     * Handle a login request to the application.
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->allWithHashedPassword());
        // $user->sendVerificationCode();

        $data = $user->getResource();

        return $this->sendResponse($data, 'success');
}
}
