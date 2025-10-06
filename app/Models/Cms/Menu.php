<?php

namespace App\Models\Cms;

use App\Observers\Cms\MenuObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([MenuObserver::class])]
class Menu extends Model
{
    protected $fillable = [
        'title',
        'slug',
    ];

    public function menuitems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Menuitem::class, 'menu_id')->orderBy('order');
    }
}
