<?php

namespace App\Traits;

trait StateDeletedTrait
{
    public function scopeIsDeleted($query)
    {
        return $query->where('state', false);
    }
}
