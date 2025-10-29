<?php

namespace App\Models\Cms;

use App\Observers\Cms\PageObserver;
use App\Traits\DefaultMediaConversions;
use App\Traits\HasUniqueSlug;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Spatie\Translatable\HasTranslations;

/**
 * @property-read object $seo
 * @property-read object $og
 * @property-read string $relativePermalink
 * @property-read string $permalink
 * @property-read Page|null $parent
 */
#[ObservedBy([PageObserver::class])]
class Page extends Model implements HasMedia, Sitemapable
{
    use DefaultMediaConversions;
    use HasTranslations;
    use HasUniqueSlug;
    use InteractsWithMedia;

    protected string $content_type = 'page';

    protected $fillable = [
        'title',
        'slug',
        'lead',
        'content',
        'meta',
        'custom_fields',
        'extras',
        'sort_order',
        'parent_id',
    ];

    protected $casts = [
        'custom_fields' => 'array',
        'extras' => 'array',
        'content' => 'array',
        'meta' => 'array',
    ];

    /**
     * @var array<string>
     */
    public $translatable = [
        'title',
        'lead',
        'content',
        'custom_fields',
        'meta',
    ];

    /**
     * @property-read string $permalink
     *
     * @return Attribute<string, never>
     */
    protected function permalink(): Attribute
    {
        $slugs = $this->getParentSlugs($this);
        $slugPath = implode('/', $slugs);

        return Attribute::make(
            get: fn () => route('cms.page', [
                'slug' => $slugPath,
            ]),
        );
    }

    /**
     * @property-read string $relativePermalink
     *
     * @return Attribute<string, never>
     */
    protected function relativePermalink(): Attribute
    {
        $slugs = $this->getParentSlugs($this);
        $slugPath = implode('/', $slugs);

        return Attribute::make(
            get: fn () => route('cms.page', [
                'slug' => $slugPath,
            ], false),
        );
    }

    public function hasFeaturedImages(): bool
    {
        return $this->getMedia('featured_images')->count() > 0;
    }

    public function registerMediaCollections(?Media $media = null): void
    {
        $this->registerCustomMediaCollections($media);
    }

    /**
     * Get the parent page of the current page.
     *
     * @return BelongsTo<Page, Page>
     */
    public function parent(): BelongsTo
    {
        /** @var BelongsTo<Page, Page> */
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Ottiene le pagine figlie della pagina corrente.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Cms\Page, \App\Models\Cms\Page>
     */
    public function children(): HasMany
    {
        /** @var HasMany<Page, Page> */
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Get the view name for the current page.
     *
     * @return string View name
     */
    public function getViewName(): string
    {
        return 'cms.templates.pages.'.($this->extras['template'] ?? 'default');
    }

    /**
     * Get the parent slugs for the current page.
     *
     * @param  self  $page  Istanza corrente della pagina.
     * @param  array<string>  $slugs  Slug accumulati.
     * @return array<string> Array di slug che rappresentano la gerarchia della pagina.
     */
    private function getParentSlugs(Page $page, array $slugs = []): array
    {
        if ($page->parent) {
            $slugs = $this->getParentSlugs($page->parent, $slugs);
        }

        $slugs[] = $page->slug;

        return $slugs;
    }

    /**
     * Get the visit tracker for the page.
     *
     * @return mixed
     */
    public function vzt()
    {
        return visits($this);
    }

    public function toSitemapTag(): Url|string|array
    {
        return Url::create(route('cms.page', [
            'slug' => $this->slug,
        ]))
            ->setLastModificationDate(Carbon::create($this->updated_at))
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setPriority(0.5);
    }
}
