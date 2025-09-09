<?php

namespace Inerba\Seo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Inerba\Seo\Seo
 */
class Seo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Inerba\Seo\Seo::class;
    }
}
