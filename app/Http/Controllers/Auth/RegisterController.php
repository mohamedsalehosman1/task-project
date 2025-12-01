<?php

namespace App\Http\Controllers\Auth;

use App\Enums\NotificationTypesEnum;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\NotificationsService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\Accounts\Entities\User;
use Modules\Vendors\Events\VendorStatusEvent;
use Modules\Vendors\Http\Requests\VendorRequest;
use Modules\Vendors\Repositories\VendorRepository;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
protected $notificationsService;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
                        // $this->notificationsService = $notificationsService;

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
protected function sendAdminNotification($vendor)
{
    $admin = User::where('type', 'admin')->first();
    if ($admin) {
        $title = ["vendors::vendors.notifications.new_vendor", ['name' => $vendor->name]];
        $message = ["vendors::vendors.notifications.new_vendor_message", ['phone' => $vendor->phone]];

        // $this->notificationsService->handleNotification(
        //     NotificationTypesEnum::NewVendor->value,
        //     $admin,
        //     $title,
        //     $message,
        //     $vendor

        // );
    }
}
    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    public function save(VendorRequest $request, VendorRepository $vendorRepository)
    {
        $vendor = $vendorRepository->create($request->allWithHashedPassword());
            $this->sendAdminNotification($vendor);

        event(new VendorStatusEvent($vendor->refresh()));

        return redirect()
            ->route('login')
            ->with('pending_store', 'تم إنشاء حسابك     يمكنك الان تسجيل الدخول .');
    }
}
