<?php

namespace App\Models\JobBoard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Brick\Math\BigInteger;

/**
 * @property BigInteger id
 * @property string institution
 * @property string position
 * @property string contact_name
 * @property string contact_phone
 * @property string contact_email
 */
class Reference extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use softDeletes;

    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.references';

    protected $fillable = [
        'institution',
        'position',
        'contact_name',
        'contact_phone',
        'contact_email'
    ];



    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

//    instancia del modelo por id
    public static function getInstance($id): Professional
    {
        $model = new Professional();
        $model->id = $id;
        return $model;
    }

//    Mutators
    public function setInstitutionAttribute($value)
    {
        $this->attributes['institution'] = strtoupper($value);
    }

    public function setPositionAttribute($value)
    {
        $this->attributes['position'] = strtoupper($value);
    }

    public function setContactNameAttribute($value)
    {
        $this->attributes['contact_name'] = strtoupper($value);
    }

    public function setContactPhoneAttribute($value)
    {
        $this->attributes['contact_phone'] = strtoupper($value);
    }

//    scopes
    public function scopeInstitution($query, $institution)
    {
        if ($institution) {

            return $query->where('institution', 'ILIKE', "%$institution%");
        }
    }

    public function scopePosition($query, $position)
    {
        if ($position) {

            return $query->orWhere('position', 'ILIKE', "%$position%");
        }
    }

    public function scopeContactName($query, $contact_name)
    {
        if ($contact_name) {

            return $query->orWhere('contact_name', 'ILIKE', "%$contact_name%");
        }
    }

    public function scopeContactPhone($query, $contact_phone)
    {
        if ($contact_phone) {

            return $query->orWhere('contact_phone', 'ILIKE', "%$contact_phone%");
        }
    }

    public function scopeContactEmail($query, $contact_email)
    {
        if ($contact_email) {

            return $query->orWhere('contact_email', 'ILIKE', "%$contact_email%");
        }
    }

}
