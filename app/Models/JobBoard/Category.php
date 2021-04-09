<?php

namespace App\Models\JobBoard;

<<<<<<< HEAD
use App\Models\App\Catalogue;
use App\Traits\StateActiveTrait;
=======
>>>>>>> cd4789bbecf8dab6676f4f04982bebad8ee407ed
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class Category extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use StateActiveTrait;

    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.categories';

    protected $fillable = [
        'code',
        'name',
<<<<<<< HEAD
        'icon',
        'state'
    ];

=======
        'icon'
    ];


>>>>>>> cd4789bbecf8dab6676f4f04982bebad8ee407ed
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

<<<<<<< HEAD
    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

=======
>>>>>>> cd4789bbecf8dab6676f4f04982bebad8ee407ed
}
