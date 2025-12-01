<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWorkingHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'day',
        'from',
        'to',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
