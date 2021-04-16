<?php

namespace App\Models\JobBoard;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Authentication\User;
use App\Models\JobBoard\Auditing;
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
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'has_travel',
        'has_license',
         'has_disability',
         'has_familiar_disability',
        'identification_familiar_disability',
         'has_catastrophic_illness',
         'has_familiar_catastrophic_illness',
         'about_me',
    ];
    //protected $appends = ['full_about_me'];

    public static function getInstance($id)
    {
        $model = new Professional();
        $model->id = $id;
        return $model;
    }

//relaciones
    public function offers()
    {
        return $this->belongsToMany(Offer::class)->withPivot('id', 'status_id')->withTimestamps();
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class)->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function academicFormations()
    {
        return $this->hasMany(AcademicFormation::class);
    }

    public function abilities()
    {
        return $this->hasMany(Ability::class);
    }

    public function languages()
    {
        return $this->hasMany(Language::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function professionalExperiences()
    {
        return $this->hasMany(ProfessionalExperience::class);
    }

    public function professionalReferences()
    {
        return $this->hasMany(ProfessionalReference::class);
    }
      // Mutators
  /*    public function setAboutMeAttribute($value)
      {
          $this->attributes['about_me'] = strtoupper($value);
      }
  
      // Scopes
      public function scopeAboutMe($query, $about_me)
      {
          if ($about_me) {
              return $query->where('about_me', 'ILIKE', "%$about_me%");
          }
      }
  
      // Accessors
      public function getFullAboutMeAttribute()
      {
          return "{$this->attributes['id']}.{$this->attributes['about_me']}";
      }
  }*/
  


}