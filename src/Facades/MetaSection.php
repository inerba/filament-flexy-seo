<?php

namespace Inerba\Seo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Inerba\Seo\MetaSection
 */
class MetaSection extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Inerba\Seo\MetaSection::class;
    }
}
