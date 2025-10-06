<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'slug',
        'extras',
    ];

    protected $casts = [
        'extras' => 'array',
    ];

    /**
     * @var array<string>
     */
    public $translatable = [
        'name',
    ];

    /**
     * Get the articles that belong to this category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Article, Category>
     */
    public function articles(): HasMany
    {
        /** @var \Illuminate\Database\Eloquent\Relations\HasMany<Article, Category> */
        return $this->hasMany(Article::class);
    }

    /**
     * Get the permalink for the post.
     *
     * @return Attribute<string, never>
     */
    protected function permalink(): Attribute
    {
        return Attribute::make(
            get: fn () => route('cms.articles.category', $this->slug),
        );
    }

    /**
     * @property-read string $relativePermalink
     *
     * @return Attribute<string, never>
     */
    protected function relativePermalink(): Attribute
    {
        return Attribute::make(
            get: fn () => route('cms.articles.category', $this->slug, false),
        );
    }
}
