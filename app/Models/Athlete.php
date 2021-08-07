<?php

namespace App\Models;

use Auth;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Athlete represents the counterpart for the database table athletes.
 *
 * @property integer $id
 * @property integer $office_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $language_code
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Agilo\Office $office
 * @property-read \Illuminate\Database\Eloquent\Collection|\Agilo\AthleteGroup[] $groups
 * @property-read \Illuminate\Database\Eloquent\Collection|\Agilo\WorkoutRoutine[] $routines
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Athlete whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Athlete whereOfficeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Athlete whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Athlete whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Athlete whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Athlete wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Athlete wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Athlete whereLanguageCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Athlete whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Athlete whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Athlete whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Athlete whereDeletedAt($value)
 * @mixin \Eloquent
 * @property \Carbon\Carbon $birth
 * @property string $sex
 * @property-read \Illuminate\Database\Eloquent\Collection|\Agilo\WorkoutUserEvent[] $workoutUserEvents
 * @property-read \Agilo\HealthRecord $healthRecord
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Athlete whereBirth($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Athlete whereSex($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Athlete visible()
 * @property boolean $active
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Athlete whereActive($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\Agilo\AssignedRoutine[] $parameterizedRoutines
 */
class Athlete extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract, JWTSubject
{
    use Authenticatable, Authorizable, CanResetPassword, SoftDeletes,HasFactory;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'birth'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'birth', 'email', 'sex'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Returns the associated office.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function office()
    {
        return $this->belongsTo('App\Models\Office');
    }

    /**
     * Returns the associated athlete groups.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany('App\Models\AthleteGroup');
    }

    /**
     *
     * @return string
     */
    public function groupNames() {
        return $this->groups
            ->map(function ($item) {
                    return $item->title;
                })
            ->implode(', ');
    }

    /**
     * Returns the currently assigned workout routines.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assignedRoutines()
    {
        return $this->hasMany('App\Models\AssignedRoutine');
    }

    public function userEvents(){
        return $this->hasMany('App\Models\GlobalUserEvent');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->id;
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function workoutUserEvents()
    {
        return $this->hasMany('App\Models\WorkoutUserEvent');
    }

    /**
     * Load the athletes of the current office.
     *
     * @param Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisible(Builder $query)
    {
        return $query->whereOfficeId(Auth::user()->office_id);
    }

    public function healthRecord()
    {
        return $this->hasOne('App\Models\HealthRecord');
    }
}
