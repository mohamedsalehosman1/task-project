<?php

namespace Modules\Vendors\Entities;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Accounts\Entities\User;
use Modules\Products\Entities\Product;

class Rate extends Model
{
    use HasFactory , Filterable;

    protected $fillable = [
        'user_id',
        'comment',
        'value',
        'rateable_id',
        'rateable_type',
    ];



    /**
     * Get the user that owns the Rate
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rateable() {
        return $this->morphTo();
    }

}
