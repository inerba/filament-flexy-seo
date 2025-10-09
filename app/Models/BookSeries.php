<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class BookSeries extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'meta' => 'array',
    ];

    /** @var array<string> */
    public $translatable = ['name', 'description'];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_series');
    }
}
