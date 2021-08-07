<?php

namespace App\Models;

use App\Models\User;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * Class Office represents the counterpart for the database table offices.
 *
 * @property integer $id
 * @property string $name
 * @property string $street
 * @property string $zip_code
 * @property string $city
 * @property string $country
 * @property string $phone
 * @property string $email
 * @property string $description
 * @property string $logo_path
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Agilo\Workout[] $workouts
 * @property-read \Illuminate\Database\Eloquent\Collection|\Agilo\WorkoutRoutine[] $routines
 * @property-read \Illuminate\Database\Eloquent\Collection|\Agilo\Athlete[] $athletes
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Office whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Office whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Office whereStreet($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Office whereZipCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Office whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Office whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Office wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Office whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Office whereLogoPath($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Office whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Office whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Office whereDeletedAt($value)
 * @mixin \Eloquent
 * @property boolean $has_billing_address
 * @property string $billing_name
 * @property string $billing_street
 * @property string $billing_zip_code
 * @property string $billing_city
 * @property string $billing_country
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Office whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Office whereIsActive($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Office whereHasBillingAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Office whereBillingName($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Office whereBillingStreet($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Office whereBillingZipCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Office whereBillingCity($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Office whereBillingCountry($value)
 * @property boolean $active
 * @property string $contact
 * @property integer $office_type_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\Agilo\AthleteGroupSport[] $sports
 * @property-read \Agilo\OfficeType $type
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Office whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Office whereContact($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Office whereOfficeTypeId($value)
 */
class Office extends Model
{
    use SoftDeletes,HasFactory;

    /**
     * The fillable fields.
     *
     * @var array
     */
    protected $fillable = ['name', 'contact', 'street','zip_code','city','country','phone','email',
                           'billing_name', 'billing_street', 'billing_zip_code', 'billing_city', 'billing_country'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Returns all associated workouts for the current office.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workouts()
    {
        return $this->hasMany('App\Models\Workout');
    }

    /**
     * Returns all associated routines for the current office.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function routines()
    {
        return $this->hasMany('Agilo\WorkoutRoutine');
    }

    public function sports()
    {
        return $this->belongsToMany('App\Models\AthleteGroupSport', 'office_sport', 'office_id', 'sport_id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\OfficeType', 'office_type_id');
    }

    /**
     * Returns all associated athletes for the current office.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function athletes()
    {
        return $this->hasMany('App\Models\Athlete');
    }

    public static function therapists() {
        return User::whereOfficeId(Auth::user()->office_id)
            ->withRole()
            ->get()
            ->filter(function ($user) {
            return $user->isTherapist();
        });
    }

    public function sportIds()
    {
        return $this->sports
            ->map(function ($item) {
                return $item->id;
            })
            ->all();
    }
}
