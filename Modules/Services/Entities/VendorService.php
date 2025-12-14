<?php

namespace Modules\Services\Entities;

use App\Http\Filters\Filterable;
use Google\Service\AdExchangeBuyerII\Price;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Vendors\Entities\Scopes\NotBlockedScope;
use Modules\Vendors\Entities\Vendor;

class VendorService extends Model
{

    use HasFactory,  Filterable , SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'service_id',
    ];

    protected $table = 'vendor_services';

    // protected $with = ['prices'];


    public function vendor()
    {
        return $this->belongsTo(Vendor::class)->withTrashed()->withoutGlobalScope(new NotBlockedScope());
    }


    public function service()
    {
        return $this->belongsTo(Service::class)->withTrashed();
    }


    public function prices()
    {
        return $this->hasMany(Price::class);
    }


    // /**
    //  *
    //  * Helper Functions
    //  *
    //  */
    // public function getPrice($size_id)
    // {
    //     return $this->prices->where('size_id', $size_id)->first()->price;
    // }
}
