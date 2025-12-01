<?php

namespace Modules\Accounts\Entities;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Accounts\Entities\Scopes\AdminScopes;
use Modules\Accounts\Transformers\AdminResource;
use Modules\Washers\Entities\Washer;
use Parental\HasParent;

class Admin extends User
{
    use HasParent, AdminScopes;

    /**
     * Get the class name for polymorphic relations.
     *
     * @return string
     */
    public function getMorphClass()
    {
        return User::class;
    }

    /**
     * Get the default foreign key name for the model.
     *
     * @return string
     */
    public function getForeignKey()
    {
        return 'user_id';
    }

    /**
     * Get the resource for admin type.
     *
     * @return \Modules\Accounts\Transformers\AdminResource
     */
    public function getResource()
    {
        return new AdminResource($this);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Accounts\Database\factories\AdminFactory::new();
    }


    /**
     * Get the washer that owns the Admin
     *
     * @return BelongsTo
     */
    public function washer(): BelongsTo
    {
        return $this->belongsTo(Washer::class);
    }
    public function isVendor()
{
    return \Modules\Vendors\Entities\Vendor::where('email', $this->email)->exists();
}
public function getImage()
{
    return $this->getFirstMediaUrl('images');
}


}
