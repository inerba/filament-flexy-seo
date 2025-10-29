<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasUniqueSlug;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Book
 *
 * @property int $id
 * @property string $title
 * @property string|null $slug
 * @property int|null $author_id
 * @property int|float $price
 * @property array<string, mixed>|null $meta
 */
class Book extends Model implements HasMedia, Sitemapable
{
    use HasTranslations, HasUniqueSlug, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'year',
        'pages',
        'isbn',
        'short_description',
        'description',
        'publisher',
        'meta',
        'product_id',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'meta' => 'array',
    ];

    /** @var array<string> */
    public $translatable = [
        'title',
        'short_description',
        'description',
    ];

    /**
     * Get the route key name for the model.
     *
     * This method overrides the default route key name used by Laravel
     * for model binding. By default, Laravel uses the primary key (usually 'id')
     * for route model binding. This method changes it to use the 'slug' attribute
     * instead.
     *
     * @return string The attribute name to be used for route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getLinkAttribute(): string
    {
        return route('books.show', $this->slug);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function book_series(): BelongsTo
    {
        return $this->belongsTo(BookSeries::class);
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(BookAuthor::class, 'book_author', 'book_id', 'book_author_id');
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'book_genre', 'book_id', 'genre_id');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        // image per la pagina del libro
        $this->addMediaConversion('large')
            ->fit(Fit::Contain, 800, 800)
            ->background('ffffff')
            ->format('jpg');

        $this->addMediaConversion('medium')
            ->fit(Fit::Contain, 600, 600)
            ->background('ffffff')
            ->format('jpg');

        $this->addMediaConversion('thumb')
            ->fit(Fit::Contain, 160, 160)
            ->background('ffffff')
            ->format('jpg');

        $this->addMediaConversion('icon')
            ->background('ffffff')
            ->fit(Fit::Contain, 90, 90)
            ->format('jpg');
    }

    /**
     * Get the permalink for the book.
     *
     * @return Attribute<string, never>
     */
    protected function permalink(): Attribute
    {
        return Attribute::make(
            get: fn () => route('books.show', [
                'book' => $this->slug,
            ]),
        );
    }

    public function toSitemapTag(): Url|string|array
    {
        return Url::create(route('books.show', [
            'book' => $this->slug,
        ]))
            ->setLastModificationDate(Carbon::create($this->updated_at))
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setPriority(0.5);
    }
}
