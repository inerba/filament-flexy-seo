<?php

namespace App\Models\Cms;

use App\Models\Cms\Scopes\OwnedByUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

#[ScopedBy([OwnedByUser::class])]
class Article extends Model implements HasMedia
{
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'published_at',
        'user_id',
        'category_id',
        'extras',
        'meta',
    ];

    protected $casts = [
        'content' => 'array',
        'extras' => 'array',
        'meta' => 'array',
        'published_at' => 'datetime',
    ];

    protected $with = [
        'category',
        'tags',
        'user',
    ];

    /**
     * @var array<string>
     */
    public $translatable = [
        'title',
        'content',
        'meta',
        'excerpt',
    ];

    /**
     * Get the category that this article belongs to.
     *
     * @return BelongsTo<Category, Article>
     */
    public function category(): BelongsTo
    {
        /** @var BelongsTo<Category, Article> */
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the tags associated with the article.
     *
     * @return BelongsToMany<Tag, Article>
     */
    public function tags(): BelongsToMany
    {
        /** @var BelongsToMany<Tag, Article> */
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Get the user of the article.
     *
     * @return BelongsTo<User, Article>
     */
    public function user(): BelongsTo
    {
        /** @var BelongsTo<User, Article> */
        return $this->belongsTo(User::class, 'user_id');
    }

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
            get: fn () => route('cms.articles.page', [
                'category' => $this->category?->slug,
                'article' => $this->slug,
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
