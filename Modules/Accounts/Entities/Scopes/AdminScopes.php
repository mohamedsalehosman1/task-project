<?php


namespace Modules\Accounts\Entities\Scopes;


trait AdminScopes
{
// scopes ------------------------------

    public function scopeWhereRole($query, $role_name)
    {
        return $query->whereHas('roles', function ($q) use ($role_name) {
            return $q->whereIn('name', (array)$role_name);
        });
    }

    public function scopeWhereRoleNot($query, $role_name)
    {
        return $query->whereHas('roles', function ($q) use ($role_name) {
            return $q->whereNotIn('name', (array)$role_name);
        });
    }

    public function scopeWasher($query)
    {
        return $query->where('belongs_to_washer', true);
    }

    public function scopeNotWasher($query)
    {
        return $query->where('belongs_to_washer', false);
    }
}
