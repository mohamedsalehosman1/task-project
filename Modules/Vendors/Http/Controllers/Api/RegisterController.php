<?php

namespace Modules\Vendors\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Modules\Vendors\Entities\Vendor;
use Modules\Vendors\Http\Requests\Api\RegisterRequest;
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
        $vendor = Vendor::create($request->allWithHashedPassword());

        $vendor->sendVerificationCode();

        $data = $vendor->getResource();

        if ($request->image && $request->image != null) {
            $vendor->addMediaFromBase64($request->image)
                ->usingFileName('image.png')
                ->toMediaCollection('images');
        }

        return $this->sendResponse($data, 'success');
    }
}
