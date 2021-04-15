<?php

namespace App\Models\JobBoard;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\JobBoard\Company;
use App\Models\JobBoard\Professional;
use App\Models\JobBoard\Location;
use App\Models\App\Catalogue;
use App\Models\App\Status;


class Offer extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $connection = 'pgsql-job-board';

    protected $fillable = [
        'code',
        'description',
        'contact_name',
        'contact_email',
        'contact_phone',
        'contact_cellphone',
        'remuneration',
        'vacancies',
        'start_date',
        'end_date',
        'aditional_information',
        'state',
    ];

    protected $casts = [
        'activities' => 'array',
        'requirements' => 'array',
    ];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function contractType()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function position()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function sector()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function workingDay()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function experienceTime()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function trainingHours()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

}
