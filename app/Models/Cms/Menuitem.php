<?php

namespace App\Models\Cms;

use App\Observers\Cms\MenuitemObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use SolutionForest\FilamentTree\Concern\ModelTree;

#[ObservedBy([MenuitemObserver::class])]
class Menuitem extends Model
{
    use ModelTree;

    protected $table = 'menuitems';

    protected $fillable = [
        'menu_id',
        'parent_id',
        'model_id',
        'type',
        'order',
        'title',
        'url',
        'target',
        'extras',
    ];

    protected $casts = [
        'parent_id' => 'integer',
        'model_id' => 'integer',
        'title' => 'array', // translatable
        'extras' => 'array',
    ];

    public function menu(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }
}
