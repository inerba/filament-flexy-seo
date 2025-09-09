<?php

namespace Inerba\Seo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Inerba\Seo\SeoFields
 */
class SeoFields extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Inerba\Seo\SeoFields::class;
    }
}
