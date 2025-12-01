<?php


namespace Modules\Vendors\Entities\Scopes;

trait VendorScopes
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new NotBlockedScope());
    }
}
