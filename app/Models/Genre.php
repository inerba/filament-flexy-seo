<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Genre extends Model
{
    use HasTranslations;

    protected $fillable = ['name'];

    /** @var array<string> */
    public $translatable = ['name'];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_genre');
    }
}
