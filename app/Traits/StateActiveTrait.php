<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait StateActiveTrait
{
    protected static function booted()
    {
        static::addGlobalScope('isActive', function (Builder $builder) {
            return $builder->where('state', true);
        });
    }

}
