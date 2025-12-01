<?php

namespace Modules\Vendors\Entities\Helpers;

use App\Enums\WasherStatusEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;
use Modules\Accounts\Entities\ResetPasswordCode;
use Modules\Accounts\Entities\Verification;
use Modules\Accounts\Events\VerificationCreated;
use Modules\Accounts\Notifications\EmailVerificationNotification;
use Modules\Vendors\Entities\Vendor;
use Modules\Vendors\Transformers\VendorResource;

trait VendorHelpers
{
    /**
     * Determine whether the vendor is verified phone.
     *
     * @return bool
     */
    public function hasVerifiedPhone()
    {
        return ($this->phone_verified_at != null);
    }

    /**
     * Determine whether the vendor is verified phone.
     *
     * @return bool
     */
    public function hasApproved()
    {
        return ($this->status == 'approved');
    }

    /**
     * Verify vendor phone.
     *
     * @return $this
     */
    public function setVerified(): self
    {
        $this->forceFill([
            'phone_verified_at' => Carbon::now(),
        ])->save();

        return $this;
    }

    /**
     * Get the number of models to return per page.
     *
     */
    public function getPerPage()
    {
        return request('perPage', parent::getPerPage());
    }

    /**
     * Get the resource for vendor type.
     *
     * @return VendorResource
     */
    public function getResource()
    {
        return new VendorResource($this);
    }

    /**
     * Get the vendor's preferred locale.
     *
     * @return string
     */
    public function preferredLocale(): string
    {
        return $this->preferred_locale ?? app()->getLocale();
    }

    /**
     * Get the access token currently associated with the user. Create a new.
     *
     * @param string|null $device
     * @return string
     */
    public function createTokenForDevice($device = null): string
    {
        $device = $device ?: 'Unknown Device';

        if ($this->currentAccessToken()) {
            return $this->currentAccessToken()->token;
        }

        $this->tokens()->where('name', $device)->delete();

        return $this->createToken($device)->plainTextToken;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getBannersAttribute()
    {
        return $this->getMediaResource('banners');
    }

    /**
     * The vendor image url.
     */
    public function getBanners()
    {
        return $this->getMedia('banners')->pluck("original_url");
    }

    /**
     * The vendor image url.
     */
    public function getImage()
    {
        return $this->getFirstMediaUrl('images');
    }

    /**
     * The vendor avatar url.
     */
    public function getAvatar()
    {
        return $this->getFirstMediaUrl('images');
    }

    /**
     * The vendor cover url.
     */
    public function getCover()
    {
        return $this->getFirstMediaUrl('covers');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getCoversAttribute()
    {
        return $this->getMediaResource('covers');
    }


    /**
     * @return
     */
    public function distanceTime($distance)
    {
        $floatHours = $distance / 100;
        // Extract the integer part for hours
        $hours = floor($floatHours);

        // Calculate the remaining fraction and convert it to minutes
        $remainingFraction = $floatHours - $hours;
        $totalMinutes = $remainingFraction * 60;
        $minutes = floor($totalMinutes);

        // Calculate the remaining fraction from minutes and convert it to seconds
        $remainingFraction = $totalMinutes - $minutes;
        $seconds = round($remainingFraction * 60);

        $formattedHours = sprintf('%02d', $hours);
        $formattedMinutes = sprintf('%02d', $minutes);
        // $formattedSeconds = sprintf('%02d', $seconds);

        // Prepare the output based on the language
        // return trans('vendors::vendors.distance-time' , ["Hours" => $formattedHours, "Minutes" => $formattedMinutes, "Seconds" => $formattedSeconds] );
        return trans('vendors::vendors.distance-time' , ["Hours" => $formattedHours, "Minutes" => $formattedMinutes] );
    }

    /**
     * @return Vendor
     */
    public function block()
    {
        return $this->forceFill(['blocked_at' => Carbon::now()]);
    }

    /**
     * @return Vendor
     */
    public function unblock()
    {
        return $this->forceFill(['blocked_at' => null]);
    }

    /**
     * @return mixed
     */
    public function getVerificationCode()
    {
        return Verification::where([
            'parentable_id' => $this->id,
            'parentable_type' => $this->getMorphClass(),
            'username' => $this->phone,
        ])->first()->code;
    }


    /**
     *
     * send verification sms to vendor
     *
     * */


    /**
     * @return void
     * @throws ValidationException
     */
    public function sendVerificationCode(): void
    {
        if (!$this || $this->email_verified_at || $this->phone_verified_at) {
            throw ValidationException::withMessages([
                'phone' => [trans('vendors::verification.verified')],
            ]);
        }

        $verification = Verification::updateOrCreate([
            'parentable_id' => $this->id,
            'parentable_type' => $this->getMorphClass(),
            'username' => $this->phone,
        ], [
            'code' => random_int(1111, 9999),
        ]);

        event(new VerificationCreated($verification));
    }


    /**
     * @param $phone
     * @param $code
     * @return void
     */
    public function sendSmsVerificationNotification($phone, $code): void
    {
        $greetings = trans('vendors::auth.register.verification.greeting', [
            'user' => $this->name,
        ]);
        $line = trans('vendors::auth.register.verification.line', [
            'code' => $code,
            'app' => Config::get('app.name'),
        ]);
        $footer = trans('vendors::auth.register.verification.footer');
        $salutation = trans('vendors::auth.register.verification.salutation', [
            'app' => Config::get('app.name'),
        ]);

        $message = $greetings . ' ' . $line . ' ' . $footer . ' ' . $salutation;

        if (request('test_mode') != 1 || !request('test_mode')) {
            // $smsService = app(SmsService::class);
            // $smsService->sendDreams($phone, $this->name, $message);
        }
    }


    /**
     *
     * send Reset Password sms to vendor
     *
     */


    /**
     * @return void
     */
    public function sendEmailVerificationNotifications(): void
    {
        $this->notify(new EmailVerificationNotification($this->verify->code));
    }


    /**
     * @param $code
     * @return void
     */
    public function sendSmsResetPasswordNotification($code): void
    {
        $greetings = trans('vendors::auth.emails.forget-password.greeting', [
            'user' => $this->name,
        ]);
        $line = trans('vendors::auth.emails.forget-password.line', [
            'code' => $code,
            'app' => Config::get('app.name'),
            'minutes' => ResetPasswordCode::EXPIRE_DURATION / 60,
        ]);
        $salutation = trans('vendors::auth.emails.forget-password.salutation', [
            'app' => Config::get('app.name'),
        ]);
        $footer = trans('vendors::auth.emails.forget-password.footer');
        $message = $greetings . ' ' . $line . ' ' . $footer . ' ' . $salutation;
        $phone = $this->phone;

        if (request('test_mode') != 1 || !request('test_mode')) {
            // $smsService = app(SmsService::class);
            // $smsService->sendDreams($phone, $this->name, $message);
        }
    }


    /*
     *
     * send approved/rejected sms to vendor
     *
     * */

    /**
     * @param $phone
     * @param $title
     * @param $message
     * @return void
     */
    public function sendSmsApprove($phone): void
    {
        $greetings = trans('vendors::auth.request.approve.greeting', [
            'user' => $this->name,
        ]);
        $line = trans('vendors::auth.request.approve.line', [
            'app' => Config::get('app.name'),
        ]);
        $footer = trans('vendors::auth.request.approve.footer');
        $salutation = trans('vendors::auth.request.approve.salutation', [
            'app' => Config::get('app.name'),
        ]);

        $message = $greetings . ' ' . $line . ' ' . $footer . ' ' . $salutation;

        if (request('test_mode') != 1 || !request('test_mode')) {
            // $smsService = app(SmsService::class);
            // $smsService->sendDreams($phone, $this->name, $message);
        }
    }

    /**
     * send rejection sms to vendor
     * @param $phone
     * @param $title
     * @param $message
     */
    public function sendSmsRejection($phone, $reason = null): void
    {
        $greetings = trans('vendors::auth.request.reject.greeting', [
            'user' => $this->name,
        ]);

        if ($reason && !is_null($reason)) {
            $line = trans('vendors::auth.request.reject.line-reason', [
                'app' => Config::get('app.name'),
                'reason' => $reason
            ]);
        } else {
            $line = trans('vendors::auth.request.reject.line', [
                'app' => Config::get('app.name'),
            ]);
        }

        $footer = trans('vendors::auth.request.reject.footer');
        $salutation = trans('vendors::auth.request.reject.salutation', [
            'app' => Config::get('app.name'),
        ]);

        $message = $greetings . ' ' . $line . ' ' . $footer . ' ' . $salutation;

        if (request('test_mode') != 1 || !request('test_mode')) {
            // $smsService = app(SmsService::class);
            // $smsService->sendDreams($phone, $this->name, $message);
        }
    }


    /**
     * send rejection sms to vendor
     * @param $phone
     * @param $title
     * @param $message
     */
    public function getIsNearestAttribute()
    {
        $lat = request('lat');
        $long = request('long');

        if ($lat && $long) {
            $nearest = self::select("*")
                ->selectRaw('( 6371 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians( `long` ) - radians(' . $long . ') ) + sin( radians(' . $lat . ') ) * sin( radians( lat ) ) ) ) AS distance')
                ->orderBy('distance', 'asc')->first();
            if ($nearest) {
                return $nearest->is($this);
            }
            return false;
        }
        return false;
    }

public function getStatusColor()
    {
        return WasherStatusEnum::colors($this->status);
    }

    public function getStatusName()
    {
        return WasherStatusEnum::translatedName($this->status);
    }

    public function getStatus()
    {
        return "<span class='badge text-white' style='background-color: {$this->getStatusColor()}'>{$this->getStatusName()}</span>";
    }
}
