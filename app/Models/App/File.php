<?php

namespace App\Models\App;

use App\Traits\StatusActiveTrait;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class File extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use StatusActiveTrait;


    protected $connection = 'pgsql-app';
    protected $table = 'app.files';

    protected $fillable = [
        'code',
        'name',
        'description',
        'extension',
        'uri',
    ];

    public function fileable()
    {
        return $this->morphTo();
    }
}
