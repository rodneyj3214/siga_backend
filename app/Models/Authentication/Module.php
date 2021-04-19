<?php

namespace App\Models\Authentication;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

// Application
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Status;
use App\Models\Authentication\System;


class Module extends Model implements Auditable
{
    use HasFactory;
    use OwenIt\Auditing\Auditable;
    use SoftDeletes;


    protected $connection = 'pgsql-authentication';
    protected $table = 'authentication.modules';

    protected $fillable = [
    'code',
    'name',
    'description',
    'icon',
    'state'];

    public static function getInstance($id)
    {
        $model = new Module();
        $model->id = $id;
        return $model;
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function system()
    {
        return $this->belongsTo(System::class);
    }

}
