<?php


namespace Modules\Vendors\Entities\Scopes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class NotBlockedScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        return $builder->whereNull('blocked_at');
    }
}
