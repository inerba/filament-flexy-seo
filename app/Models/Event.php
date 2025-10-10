<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Event extends Model implements HasMedia
{
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'location',
        'date',
        'subtitle',
        'content',
        'excerpt',
        'published_at',
        'extras',
        'meta',
    ];

    protected $casts = [
        'content' => 'array',
        'extras' => 'array',
        'meta' => 'array',
        'published_at' => 'datetime',
    ];

    /**
     * @var array<string>
     */
    public $translatable = [
        'title',
        'subtitle',
        'location',
        'date',
        'content',
        'meta',
        'excerpt',
    ];

    /**
     * Register the media collections for the article.
     */
    public function registerMediaCollections(?Media $media = null): void
    {
        $this->addMediaConversion('lg')
            ->width(1280)
            ->format('jpg');

        $this->addMediaConversion('thumbnail')
            ->fit(Fit::Crop, 720, 488)
            ->format('jpg');

        $this->addMediaConversion('square')
            ->fit(Fit::Crop, 600, 600)
            ->format('jpg');

        $this->addMediaConversion('icon')
            ->fit(Fit::Crop, 90, 90)
            ->format('jpg');
    }

    /**
     * Scope a query to only include published articles.
     */
    #[Scope]
    protected function published(Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    /**
     * Scope scheduled articles.
     */
    #[Scope]
    protected function scheduled(Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('published_at', '>', now());
    }

    /**
     * Scope drafts articles.
     */
    #[Scope]
    protected function drafts(Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->whereNull('published_at');
    }

    /**
     * Get the published status for the post.
     *
     * @return Attribute<string, never>
     */
    protected function isPublished(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->published_at !== null && $this->published_at->isPast(),
        );
    }

    /**
     * Get the permalink for the post.
     *
     * @return Attribute<string, never>
     */
    protected function permalink(): Attribute
    {
        return Attribute::make(
            get: fn () => route('events.show', [
                'event' => $this->slug,
            ]),
        );
    }

    /**
     * Get the visit tracker for the article.
     *
     * @return mixed
     */
    public function vzt()
    {
        return visits($this);
    }
}
