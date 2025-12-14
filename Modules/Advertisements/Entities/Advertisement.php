<?php

namespace Modules\Advertisements\Entities;

use App\Http\Filters\Filterable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Advertisements\Entities\Helpers\AdvertisementHelpers;
use Modules\Advertisements\Entities\Relations\AdvertisementRelations;
use Modules\Advertisements\Entities\Scopes\AdvertisementScopes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Advertisement extends Model implements HasMedia
{
    use
        HasFactory,
        Translatable,
        Filterable,
        InteractsWithMedia,
        AdvertisementHelpers,
        AdvertisementScopes,
        AdvertisementRelations;

    protected $fillable = [
        'defined',
        'start_at',
        'end_at',
        'vendor_id',
        'active',
        'auto_popup'
    ];

    protected $table = 'advertisements';

    public $translatedAttributes = ['title', 'description'];

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
     * @var string[]
     */
protected $casts = [
    'start_at' => 'datetime',
    'end_at'   => 'datetime',
    'defined'  => 'boolean',
    'active'   => 'boolean',
    'auto_popup' => 'boolean',
];


    /**
     * @var string[]
     */
    protected $appends = ['duration'];

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
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            if ($model->defined == false) {
                $model->start_at = null;
                $model->end_at = null;
            }
        });
    }
}
