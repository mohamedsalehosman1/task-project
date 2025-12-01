<?php

namespace Modules\Categories\Entities;

use AhmedAliraqi\LaravelMediaUploader\Entities\Concerns\HasUploader;
use App\Http\Filters\Filterable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Services\Entities\Service;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{
    use HasFactory, Translatable, Filterable, InteractsWithMedia;
    protected $fillable = ["rank", 'type','created_at', 'updated_at'];

    protected $table = 'categories';

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
        $this->addMediaCollection('images')
            ->useFallbackUrl('https://cdn.shopify.com/s/files/1/0422/0194/0126/products/CombinePhotos_800x.png?v=1633998941')
            ->registerMediaConversions(function () {
                $this->addMediaConversion('webp')
                    ->optimize()
                    ->width(720)
                    ->format('webp');
            });
    }

    /**
     * The Category image url.
     *
     * @return bool
     */
    public function getImage()
    {
        return $this->getFirstMediaUrl('images', 'webp');
    }
    public function projects()
    {
        return $this->hasMany(\Modules\Projects\Entities\Project::class, 'category_id', 'id')->with('translations','media');
    }

    public function products()
    {
        return $this->hasMany(Service::class, 'category_id', 'id')->with('translations','media');
    }
}
