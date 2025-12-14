<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{

    protected $table = 'product_materials';

    protected $fillable = [
        'product_id',
        'material',
    ];

}
