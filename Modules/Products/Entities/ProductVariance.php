<?php

namespace Modules\Products\Entities;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Colors\Entities\Color;
use Modules\Sizes\Entities\Size;

class ProductVariance extends Model
{
    use Filterable, SoftDeletes;

    protected $fillable = [
        'product_id',
        'size_id',
        'color_id',
        'quantity',
        'deleted_at',
    ];

    protected $table = 'product_variances';

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function getQuantity($color_id)
    {
        return $this->product->productVariances()
            ->where([
                'color_id' => $color_id,
                'size_id' => $this->size_id
            ])
            ->first()?->quantity ?? 0;
    }
}
