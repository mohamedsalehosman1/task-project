<?php

namespace Modules\Services\Entities;

use App\Http\Filters\Filterable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\UserProduct;
use Modules\Services\Entities\Scopes\ServiceScopes;
use Modules\Support\Traits\MediaTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Service extends Model implements HasMedia
{
    use HasFactory,
        Translatable,
        Filterable,
        MediaTrait,
        ServiceScopes,
        InteractsWithMedia,
        SoftDeletes;

    protected $fillable = [

        'name'
    ];

    protected $table = 'services';

    public $translatedAttributes = ['name'];

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
     * The Partner image url.
     */
    public function getImage()
    {
        return $this->getFirstMediaUrl('images');
    }


    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get all of the subServices for the Service
     *
     * @return HasMany
     */
    public function subServices(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }
public function products()
{
    return $this->hasMany(Product::class);
}
public function userproducts()
{
    return $this->hasMany(UserProduct::class);
}


}
