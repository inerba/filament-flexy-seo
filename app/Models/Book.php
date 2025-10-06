<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasUniqueSlug;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Number;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
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
class Book extends Model implements HasMedia
{
    use HasTranslations, HasUniqueSlug, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'author_id',
        'year',
        'pages',
        'isbn',
        'short_description',
        'description',
        'publisher',
        'meta',
        'price',
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

    public function author(): BelongsTo
    {
        return $this->belongsTo(BookAuthor::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'book_genre');
    }

    public function getFormattedPriceAttribute(): string
    {
        return Number::currency($this->price, 'EUR', 'it_IT');
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value * 100,
            get: fn ($value) => $value / 100,
        );
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        // image per la pagina del veicolo
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
}
