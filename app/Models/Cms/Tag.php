<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Tag extends Model
{
    use HasTranslations;

    protected $fillable = ['name'];

    protected $casts = [
        'name' => 'array',
    ];

    /** @var array<string> */
    public $translatable = ['name'];
}
