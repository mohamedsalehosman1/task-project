<?php

namespace Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Orders\Database\factories\OrderTaxFactory;
use Modules\Taxes\Entities\Tax;

class OrderTax extends Model
{
    use HasFactory;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'order_id',
        'tax_id',

        'percentage',
        'total',
    ];



    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class)->withTrashed();
    }


    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory()
    {
        return OrderTaxFactory::new();
    }
}
