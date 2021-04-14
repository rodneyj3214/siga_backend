<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

// Application
use App\Models\Authentication\Role;
use Illuminate\Database\Eloquent\SoftDeletes;



class Catalogue extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;


    protected $connection = 'pgsql-app';
    protected $table = 'app.catalogues';


    protected $fillable = [
        'code',
        'name',
        'type',
        'icon',
        'state'
    ];
    public static function getInstance($id)
    {
        $model = new Catalogue();
        $model->id = $id;
        return $model;
    }
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

    public function parent()
    {
        return $this->belongsTo(Catalogue::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Catalogue::class, 'parent_id');
    }

    // Relaciones Polimorficas
    public function roles()
    {
        return $this->morphedByMany(Role::class, 'catalogueable');
    }
}
