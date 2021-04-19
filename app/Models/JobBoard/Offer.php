<?php

namespace App\Models\JobBoard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use \OwenIt\Auditing\Auditable as Auditing;
use OwenIt\Auditing\Contracts\Auditable;

use App\Models\App\Catalogue;
use App\Models\App\Status;

// NOTA: estan bien los tipos de datos?
/**
 * @property BigInteger id
 * @property string code
 * @property string description
 * @property string contact_name
 * @property string contact_email
 * @property string contact_phone
 * @property string contact_cellphone
 * @property string remuneration
 * @property integer vacancies
 * @property date start_date
 * @property date end_date
 * @property text aditional_information
 */
class Offer extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;
  
    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.offers';

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
