<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait StatusActiveTrait
{
    protected static function booted()
    {
        static::addGlobalScope('isActive', function (Builder $builder) {
            return $builder->where('state', true);
        });
    }

}
