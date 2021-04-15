<?php

namespace App\Models\JobBoard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

use App\Traits\StatusActiveTrait;

use App\Models\Authentication\User;


class Professional extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use StatusActiveTrait;
    use SoftDeletes;


    public $skill = null;
    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.professionals';


    protected $fillable = [
        'has_online_interview',
       'has_travel',
       'has_license',
        'has_vehicle',
        'has_disability',
        'has_familiar_disability',
       'identification_familiar_disability',
        'has_catastrophic_illness',
        'has_familiar_catastrophic_illness',
        'about_me',
    ];

//protected $appends =['full_description'];

    public static function getInstance($id)
    {
        $model = new Professional();
        $model->id = $id;
        return $model;
    }


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

    public function skills()
    {
        return $this->hasMany(Skill::class);
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
        return $this->hasMany(Experience::class);
    }

    public function professionalReferences()
    {
        return $this->hasMany(Reference::class);
    }


}
