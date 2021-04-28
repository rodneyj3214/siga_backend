<?php

namespace App\Models\Authentication;


// Laravel
use App\Models\App\Address;
use App\Models\JobBoard\Professional;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\AdministrativeStaff;
use App\Models\App\Catalogue;
use App\Models\App\Image;
use App\Models\App\Institution;
use App\Models\App\Teacher;
use App\Models\App\Status;
use App\Models\App\File;


class User extends Authenticatable implements Auditable
{
    use HasApiTokens, Notifiable, HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-authentication';
    protected $table = 'authentication.users';

    protected static $instance;

    const ATTEMPTS = 3;

    protected $fillable = [
        'identification', //s
        'first_name', //s
        'second_name', //s
        'first_lastname', //s
        'second_lastname', //s
        'personal_email',
        'birthdate',
        'avatar',
        'username',
        'phone',
        'email', //s
        'email_verified_at',
        'password',
        'changed_password',
        'attempts'
    ];

    protected $appends = ['full_name', 'parcial_name'];


    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    // Definir el campo por el cual se valida con passport el usuario
    public function findForPassport($username)
    {
        return $this->firstWhere('username', $username);
    }

    // Relationships
    public function professional()
    {
        $this->hasOne(Professional::class);
    }

    public function securityQuestions()
    {
        $this->belongsToMany(SecurityQuestion::class)->withPivot('answer')->withTimestamps();
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function ethnicOrigin()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function Address()
    {
        return $this->belongsTo(Address::class);
    }

    public function identificationType()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function sex()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function gender()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function bloodType()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function institutions()
    {
        return $this->morphToMany(Institution::class, 'institutionable', 'app.institutionables');
    }

    public function administrativeStaff()
    {
        return $this->hasOne(AdministrativeStaff::class);
    }

    //Accessors
    public function getFullNameAttribute()
    {
        return "{$this->attributes['first_name']} {$this->attributes['second_name']} {$this->attributes['first_lastname']} {$this->attributes['second_lastname']}";
    }

    public function getParcialNameAttribute()
    {
        return "{$this->attributes['first_name']} {$this->attributes['first_lastname']}";
    }
    // Scopes
}
