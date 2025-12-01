<?php

namespace Modules\Carts\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Carts\Entities\Relations\CartRelations;

class Cart extends Model
{
    use CartRelations;

    protected $fillable = [
        'cartable_id',
        'cartable_type',
    ];
}
