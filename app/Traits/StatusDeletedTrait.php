<?php

namespace App\Traits;

trait StatusDeletedTrait
{
    public function scopeIsDeleted($query)
    {
        return $query->where('state', false);
    }
}
