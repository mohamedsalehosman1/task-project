<?php

namespace Modules\Products\Entities;

use App\Http\Filters\Filterable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Products\Entities\Relations\ProductRelations;
use Modules\Support\Traits\Favorable;
use Modules\Support\Traits\MediaTrait;
use Modules\Support\Traits\Selectable;
use Modules\Vendors\Entities\Vendor;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, Translatable, Filterable, MediaTrait, Selectable, InteractsWithMedia, ProductRelations, Favorable;

    protected $table = 'products';

    protected $fillable = [
    'vendor_id',
    'status',
    'pay_type',
    'service_id',
    'old_price',
    'region_id',
    'status',
    'price',
    'has_quantity_limit',
    'max_amount',
    'base_preparation_time',
    'extra_time_value',
    'extra_time_unit',
'active',
];

    public $translatedAttributes = ['name', 'description','company_name','admin_reply'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'translations',
        'media',
    ];


    /**
     * Define the media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');
    }

    /**
     * The model image url.
     *
     * @return string
     */
    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('images');
    }
public function addresses()
{
    return $this->belongsToMany(\Modules\Addresses\Entities\Address::class, 'product_addresses')
                ->withPivot(['latitude', 'longitude','range'])
                ->withTimestamps();
}

public function productAddresses()
{
    return $this->hasMany(\Modules\Products\Entities\ProductAddress::class);
}
public function workingHours()
{
    return $this->hasMany(ProductWorkingHour::class);
}


    /**
     * The model cover url.
     *
     * @return string
     */
    public function getCoverAttribute()
    {
        return $this->getFirstMediaUrl('covers');
    }


    /**
     * The model images url.
     *
     * @return string
     */
    public function getImagesAttribute()
    {
        return $this->getMediaResource('images')->pluck('url');
    }


    /**
     * The model images url.
     *
     * @return string
     */
    public function getImages()
    {
        return $this->getMediaResource('images');
    }


    public function getOfferPriceAttribute()
    {
        return $this->offer?->price;
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
     public function isActive()
    {
        if ($this->active == 1) {
            return true;
        }
        return false;
    }
}
