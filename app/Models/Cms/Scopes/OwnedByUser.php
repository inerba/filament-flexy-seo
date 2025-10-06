<?php

namespace App\Models\Cms\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class OwnedByUser implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {

        if (Auth::guest()) {
            return;
        }

        $user = Auth::user();

        if (! $user->hasAnyRole(['admin', 'super_admin'])) {
            $builder->where('user_id', $user->id);
        }
    }
}
