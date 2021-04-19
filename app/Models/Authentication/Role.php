<?php

namespace App\Models\Authentication;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

// Application
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\App\Catalogue;
use App\Models\App\Institution;


class Role extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;


    protected $connection = 'pgsql-authentication';
    protected $table = 'authentication.roles';

    protected $fillable = [
        'code',
        'name',
        'state',
    ];

    public static function getInstance($id)
    {
        $model = new Role();
        $model->id = $id;
        return $model;
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function system()
    {
        return $this->belongsTo(System::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function shortcuts()
    {
        return $this->hasMany(Shortcut::class);
    }

    public function catalogues()
    {
        return $this->morphToMany(Catalogue::class, 'catalogueable');
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}
