<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

// Application
use App\Traits\StateActive;
use phpseclib3\Math\BigInteger;

/**
 * @property BigInteger id
 * @property string name
 * @property string description
 * @property string extension
 * @property string directory
 */
class Image extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use StateActive;

    protected $connection = 'pgsql-app';
    protected $table = 'app.images';

    protected $fillable = [
        'name',
        'description',
        'extension',
        'directory',
    ];

    protected $appends = ['full_name', 'full_path'];

    // Relationships
    public function imageable()
    {
        return $this->morphTo();
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return "{$this->id}.{$this->extension}";
    }

    public function getFullPathAttribute()
    {
        return "images/{$this->id}.{$this->extension}";
    }
}
