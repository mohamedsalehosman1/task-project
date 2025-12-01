<?php


namespace Modules\Accounts\Entities\Relations;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Accounts\Entities\Verification;
use Modules\Addresses\Entities\Address;
use Modules\Companies\Entities\Company;
use Modules\Courses\Entities\Course;
use Modules\Interests\Entities\Interest;
use Modules\Orders\Entities\Order;
use Modules\Vendors\Entities\Vendor;
use Modules\Wallets\Entities\Wallet;
use Modules\Washers\Entities\Rate;
use Modules\Washers\Entities\Washer;

trait UserRelations
{

    /**
     * Get the user's verification.
     */
    public function verification(): MorphOne
    {
        return $this->morphOne(Verification::class, 'parentable');
    }
// App\Models\User
public function vendor()
{
    return $this->belongsTo(Vendor::class, 'vendor_id');
}



    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rates(): HasMany
    {
        return $this->hasMany(Rate::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the washer that owns the UserRelations
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    // public function washer(): BelongsTo
    // {
    //     return $this->belongsTo(Washer::class);
    // }

    /**
     * Get the company that owns the UserRelations
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    // App\Models\User.php أو المكان المناسب
public function interests()
{
    return $this->belongsToMany(Interest::class)->withPivot('is_interested')->withTimestamps();
}

// في الـ User Model


public function courses()
{
    return $this->hasMany(Course::class, 'vendor_id', 'vendor_id');
}


   public function isVendor()
{
    return \Modules\Vendors\Entities\Vendor::where('email', $this->email)->exists();
}
}
