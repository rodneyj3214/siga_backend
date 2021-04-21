<?php

namespace App\Models\Community;

use Illuminate\Database\Eloquent\Model;

class CharitableInstitution extends Model
{
    protected $connection = 'pgsql-community';
     //utilizacion para el tipo json
     protected $casts=[
        'indirect_beneficiaries'=>'array',
        'direct_beneficiaries'=>'array',
    ];
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

}
