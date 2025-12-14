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
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, Translatable, Filterable, MediaTrait, Selectable, InteractsWithMedia, ProductRelations, Favorable;

    protected $table = 'products';

    protected $fillable = [
        'vendor_id',
        'service_id',
        'old_price',
        'price',
        'is_recommended',
        'count_of_sold',
        'made_in',
        'rate'
    ];

    public $translatedAttributes = ['name', 'description'];

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
}
