<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

/**
 * App\Models\BookAuthor
 *
 * @property int $id
 * @property string $name
 * @property string|null $bio
 */
class BookAuthor extends Model implements HasMedia, Sitemapable
{
    use InteractsWithMedia;

    protected $fillable = ['name', 'slug', 'bio'];

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

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_author', 'book_author_id', 'book_id');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        // image per la pagina del veicolo
        $this->addMediaConversion('large')
            ->fit(Fit::Contain, 800, 800)
            ->format('jpg');

        $this->addMediaConversion('medium')
            ->fit(Fit::Contain, 600, 600)
            ->format('jpg');

        $this->addMediaConversion('thumb')
            ->fit(Fit::Contain, 160, 160);
        // ->format('jpg');

        $this->addMediaConversion('icon')
            ->fit(Fit::Contain, 90, 90);
        // ->format('jpg');
    }

    /**
     * Get the permalink for the bookAuthor.
     *
     * @return Attribute<string, never>
     */
    protected function permalink(): Attribute
    {
        return Attribute::make(
            get: fn () => route('book-authors.show', [
                'bookAuthor' => $this->slug,
            ]),
        );
    }

    /**
     * @throws BindingResolutionException
     * @throws InvalidFormatException
     */
    public function toSitemapTag(): Url|string|array
    {
        return Url::create($this->permalink)
            ->setLastModificationDate(Carbon::create($this->updated_at))
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setPriority(0.5);
    }
}
