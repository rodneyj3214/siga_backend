<?php

namespace App\Models\JobBoard;

use Illuminate\Database\Eloquent\Model;
use \OwenIt\Auditing\Auditable as Auditing;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Authentication\User;
use Brick\Math\BigInteger;

/**
 * @property BigInteger id
 * @property string description
 * @property boolean state
 */

class Professional extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.professionals';

    protected $fillable = [
        'has_travel',
         'has_disability',
         'has_familiar_disability',
        'identification_familiar_disability',
         'has_catastrophic_illness',
         'has_familiar_catastrophic_illness',
         'about_me',
    ];

    protected $casts = [
        'has_travel'=>'boolean',
         'has_disability'=>'boolean',
         'has_familiar_disability'=>'boolean',
        'identification_familiar_disability'=>'boolean',
         'has_catastrophic_illness'=>'boolean',
         'has_familiar_catastrophic_illness'=>'boolean',
         'about_me'=>'boolean',
    ];

    public static function getInstance($id)
    {
        $model = new Professional();
        $model->id = $id;
        return $model;
    }


//relations



    public function references()
    {
        return $this->hasMany(Reference::class);
    }



   // Mutators
      public function setAboutMeAttribute($value)
      {
          $this->attributes['about_me'] = strtoupper($value);
      }
  }



