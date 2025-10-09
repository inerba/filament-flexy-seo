<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\BookAuthor
 *
 * @property int $id
 * @property string $name
 * @property string|null $bio
 */
class BookAuthor extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['name', 'bio'];

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
}
