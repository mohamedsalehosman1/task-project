<?php

namespace Modules\Products\Entities;

use App\Http\Filters\Filterable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Addresses\Entities\Region;
use Modules\Products\Entities\Relations\ProductRelations;
use Modules\Support\Traits\Favorable;
use Modules\Support\Traits\MediaTrait;
use Modules\Support\Traits\Selectable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class UserProduct extends Model implements HasMedia
{
    use HasFactory, Translatable, Filterable, MediaTrait, Selectable, InteractsWithMedia, ProductRelations, Favorable;

    protected $table = 'user_products';

    protected $fillable = [
        'user_id',
        'status',
        'service_id',
        'old_price',
        'region_id',
        'phone',
        'available',
        'nationality'

    ];

    public $translatedAttributes = ['name', 'description', 'company_name', 'admin_reply', 'user_service_name'];

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
 public function isActive()
    {
        if ($this->active == 1) {
            return true;
        }
        return false;
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
        return $this->belongsToMany(\Modules\Addresses\Entities\Address::class, 'user_product_addresses')
            ->withPivot(['latitude', 'longitude'])
            ->withTimestamps();
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
    public function region()
    {
        return $this->belongsTo(Region::class);
    }
    public function getOfferPriceAttribute()
    {
        return $this->offer?->price;
    }
}
