<?php

namespace Inerba\Seo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Inerba\Seo\SocialFields
 */
class SocialFields extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Inerba\Seo\SocialFields::class;
    }
}
