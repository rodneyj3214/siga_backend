<?php

namespace App\Models\App;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

// Application
use App\Traits\StatusActiveTrait;


class Career extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use StatusActiveTrait;

    protected $connection = 'pgsql-app';
    protected $table = 'app.careers';

    protected $fillable = [
        'code',
        'name',
        'description',
        'resolution_number',
        'title',
        'acronym',
        'state',
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function modality()
    {
        return $this->belongsTo(Catalogue::class, 'modality_id');
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class, 'type_id');
    }
}
