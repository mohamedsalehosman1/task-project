<?php

namespace Modules\Accounts\Http\Controllers\Api;

use App\Enums\NotificationTypesEnum;
use App\Services\NotificationsService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Modules\Accounts\Entities\User;
use Modules\Accounts\Http\Filters\RateFilter;
use Modules\Accounts\Http\Requests\Api\RateApiRequest;
use Modules\Support\Traits\ApiTrait;

use Modules\Vendors\Entities\Rate;
use Modules\Vendors\Entities\Vendor;
use Modules\Vendors\Transformers\RatesResource;

class RateController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, ApiTrait;
    protected $notificationsService;


    public function __construct(NotificationsService $notificationsService)
    {
        $this->middleware('isUser');
        $this->notificationsService = $notificationsService;
    }

    public function index(RateFilter $filter)
    {
        $rateableTypeMap = [
            'course' => \Modules\Courses\Entities\Course::class,
            'vendor' => \Modules\Vendors\Entities\Vendor::class,
        ];

        $rateableType = request('rateable_type');
        $rateableId = request('rateable_id');
        if ($rateableType && isset($rateableTypeMap[$rateableType])) {
            $rateableType = $rateableTypeMap[$rateableType];
        } else {
            $rateableType = null;
        }

        $query = Rate::with(['replies.user'])->filter($filter);

        // لو الاتنين مبعوتين مع بعض
        if ($rateableType && $rateableId) {
            $query->where('rateable_type', $rateableType)
                ->where('rateable_id', $rateableId);
        } else {
            if ($rateableType) {
                $query->where('rateable_type', $rateableType);
            }

            if ($rateableId) {
                $query->where('rateable_id', $rateableId);
            }
        }

        $rates = $query->paginate(request('perPage'));

        return $this->sendResponse(
            RatesResource::collection($rates)->response()->getData(true),
            __("accounts::rate.messages.created")
        );
    }


    public function store(RateApiRequest $request)
{
    $user = auth()->user();

    $rateableTypeMap = [
        'course' => \Modules\Courses\Entities\Course::class,
        'vendor' => \Modules\Vendors\Entities\Vendor::class,
    ];

    $rateableType = $rateableTypeMap[$request->rateable_type] ?? null;

    if (!$rateableType) {
        return $this->sendError('نوع التقييم غير مدعوم');
    }

    $rate = Rate::updateOrCreate([
        'user_id' => $user->id,
        'rateable_type' => $rateableType,
        'rateable_id' => $request->rateable_id,
    ], [
        'value'   => $request->value,
        'comment' => $request->comment,
    ]);

    $average = Rate::where([
        'rateable_type' => $rateableType,
        'rateable_id'   => $request->rateable_id,
    ])->avg('value');

    $rateableModel = $rateableType::find($request->rateable_id);
    if ($rateableModel && \Schema::hasColumn($rateableModel->getTable(), 'rate')) {
        $rateableModel->update(['rate' => round($average, 2)]);
    }

    $rate->load('replies.user');

    $title   = [__('rates::rates.notifications.created.title')];
    $message = [__('rates::rates.notifications.created.body', [
        'user' => $user->name,
        'item' => $request->rateable_type,
    ])];

    $recipients = collect();

    if ($request->rateable_type === 'vendor') {
        // صاحب الـ vendor
        $vendorRecipient = User::where('vendor_id', $request->rateable_id)->first();
        if ($vendorRecipient) {
            $recipients->push($vendorRecipient);
        }

    } elseif ($request->rateable_type === 'course') {
        if ($rateableModel && $rateableModel->vendor) {
            $vendor = $rateableModel->vendor;

            if ($vendor->type === 'center') {
                // نجيب الـ user بتاع الـ center
                $centerUser = User::where('vendor_id', $vendor->id)->first();
                if ($centerUser) {
                    $recipients->push($centerUser);
                }

            } elseif ($vendor->type === 'instructor' && $vendor->center_id) {
                // نجيب الـ center المرتبط بالـ instructor
                $centerVendor = Vendor::find($vendor->center_id);
                if ($centerVendor) {
                    $centerUser = User::where('vendor_id', $centerVendor->id)->first();
                    if ($centerUser) {
                        $recipients->push($centerUser);
                    }
                }
            }
        }
    }

    $superAdmins = User::whereHas('roles', function ($q) {
        $q->where('name', 'super_admin');
    })->get();

    $recipients = $recipients->merge($superAdmins)->unique('id')->filter();

    foreach ($recipients as $recipient) {
        $this->notificationsService->handleNotification(
            NotificationTypesEnum::NewRate->value,
            $recipient,
            $title,
            $message,
            $rate,
        );
    }

    return $this->sendResponse(new RatesResource($rate), __("accounts::rate.messages.created"));
}
public function destroy($id)
{
    $user = auth()->user();
    $rate = Rate::findOrFail($id);

    if ($rate->user_id !== $user->id && !$user->hasRole('super_admin')) {
        return $this->sendError(__('accounts::rate.messages.unauthorized'), 403);
    }

    $rate->delete();

    return $this->sendResponse([], __('accounts::rate.messages.deleted'));
}


}
