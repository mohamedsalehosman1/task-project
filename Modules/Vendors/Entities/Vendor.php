<?php

namespace Modules\Vendors\Entities;

use App\Http\Filters\Filterable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Support\Traits\Favorable;
use Modules\Support\Traits\MediaTrait;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Vendors\Entities\Helpers\VendorHelpers;
use Modules\Vendors\Entities\Relations\VendorRelations;
use Modules\Vendors\Entities\Scopes\VendorScopes;
use Lab404\Impersonate\Models\Impersonate;
use Spatie\MediaLibrary\InteractsWithMedia;

class Vendor extends Authenticatable implements HasMedia, HasLocalePreference
{
    use Notifiable,
        HasApiTokens,
        VendorScopes,
        VendorHelpers,
        VendorRelations,
        InteractsWithMedia,
        Filterable,
        SoftDeletes,
        Translatable,
        Favorable,
        MediaTrait,
        HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'email',
        'phone',
        'rate',
        'address',
        'lat',
        'status',
        'long',
       'commercial_registration_number',
       'identity_number'
    ];


    protected $guard = "vendor";

    public $translatedAttributes = ['name', 'description','nationality'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'translations',
        'media',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'phone_verified_at' => 'datetime',
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'blocked_at',
        'last_login_at',
    ];


    /**
     * Define the media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->useFallbackUrl('https://www.nbmchealth.com/wp-content/uploads/2018/04/default-placeholder.png')
            ->singleFile();
    }


    /**
     * Determine whither the user can impersonate another user.
     *
     * @return bool
     */
    public function canImpersonate(): bool
    {
        return true;
    }

    /**
     * Determine whither the user can be impersonated by the admin.
     *
     * @return bool
     */
    public function canBeImpersonated(): bool
    {
        return true;
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isVendor()
    {
        return $this->role === 'vendor';
    }

}
