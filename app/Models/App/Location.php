<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

// Tratis State
use App\Traits\StateActiveTrait;

class Location extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use StateActiveTrait;


    protected $connection = 'pgsql-app';
    protected $table = 'app.locations';

    protected $fillable = [
        'code',
        'name',
        'short_name',
        'state'
    ];

    public function parent()
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function children()
    {
        return $this->hasMany(Location::class, 'parent_id');
    }
}
