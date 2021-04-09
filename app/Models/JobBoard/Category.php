<?php

namespace App\Models\JobBoard;

use App\Models\App\Catalogue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class Category extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.categories';

    protected $fillable = [
        'code',
        'name',
        'icon'
    ];


    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

}
