<?php


namespace Modules\Orders\Entities\Scopes;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class OrderGlobalScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        return $builder->whereNotIn('status' ,[OrderStatusEnum::prepending->value]);
    }
}
