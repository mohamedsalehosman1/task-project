<?php

namespace Modules\Services\Entities; // You might want to rename this namespace to 'Invitations' or just 'App\Models'

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Accounts\Entities\User;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
// NOTE: I've removed Translatable and related imports as they seem unnecessary for typical invitation fields.
// If you want multilingual fields (like a general title/theme), you can re-add them.
use Modules\Services\Entities\Scopes\ServiceScopes; // Consider renaming/removing this if it's Service-specific
use Modules\Support\Traits\MediaTrait; // Assuming this trait is generic for media handling

class Invitation extends Model implements HasMedia
{
    use HasFactory,
        Filterable,
        MediaTrait,
        ServiceScopes, // Keep or remove based on its relevance to the Invitation entity
        InteractsWithMedia;
        // SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invitations';

    /**
     * The attributes that are mass assignable.
     * These match the fields we discussed in the database migration.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'event_type',
        'groom_name',
        'bride_name',
        'event_date',
        'event_time',
        'location_text',
        'location_url',
        'quran_verse',
        'image_url', // If you're storing the image URL directly in the DB instead of Spatie Media
        'invitation_text',
        'status',
        // 'name' // Only if you still need a generic name field
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        // 'translations', // Removed: No longer using Translatable package
        'media',
    ];

    // Removed: public $translatedAttributes = ['name'];

    /**
     * Define the media collections (Spatie Media Library).
     *
     * @return void
     */
  public function registerMediaCollections(): void
{
    $this->addMediaCollection('main_photo')->singleFile();
}

public function getInvitationPhotoUrl(): ?string
{
    return $this->getFirstMediaUrl('main_photo');
}


    /* -------------------------------------------------------------------------- */
    /* Relationships                               */
    /* -------------------------------------------------------------------------- */

    /**
     * Get the user that owns the invitation.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        // Assuming the user is in the default App\Models\User path
        return $this->belongsTo(User::class, 'user_id');
    }

    // Removed: parent() and subServices() as they imply a hierarchy not typical for a single invitation.
    // Removed: products() and userproducts() as invitations don't typically have those relationships.

}
