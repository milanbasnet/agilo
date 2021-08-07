<?php

namespace App\Models;

use App\Models\Sex;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * Class AthleteGroup represents the counterpart for the database table athlete_groups.
 *
 * @property integer $id
 * @property integer $office_id
 * @property string $title
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Agilo\Athlete[] $athletes
 * @property-read \Agilo\Office $office
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AthleteGroup whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AthleteGroup whereOfficeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AthleteGroup whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AthleteGroup whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AthleteGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AthleteGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AthleteGroup whereDeletedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Agilo\WorkoutRoutine[] $routines
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AthleteGroup visible()
 * @property boolean $workouts_per_week
 * @property integer $level_id
 * @property integer $sport_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\Agilo\User[] $users
 * @property-read \Agilo\AthleteGroupLevel $level
 * @property-read \Agilo\AthleteGroupSport $sport
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AthleteGroup whereWorkoutsPerWeek($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AthleteGroup whereLevelId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AthleteGroup whereSportId($value)
 */
class AthleteGroup extends Model
{
    use SoftDeletes,HasFactory;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = ['title', 'description', 'workouts_per_week'];

    /**
     * Returns the associated athletes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function athletes()
    {
        return $this->belongsToMany('App\Models\Athlete');
    }

    public function athleteNames() {
        return $this->athletes
            ->map(function ($item) {
                return $item->first_name . ' ' . $item->last_name;
            })
            ->implode(', ');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function userIds()
    {
        return $this->users
            ->map(function ($item) {
                return $item->id;
            })
            ->all();
    }

    public function level() {
        return $this->belongsTo('App\Models\AthleteGroupLevel');
    }

    public function sport() {
        return $this->belongsTo('App\Models\AthleteGroupSport');
    }

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
     *
     * Load the athletes group the current user is assigned to as therapist.
     *
     * Office admins see all groups of their office
     *
     * @param Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisible(Builder $query)
    {
        $user = Auth::user();

        if($user->isOfficeAdmin()){
            return $query->whereOfficeId($user->office_id);
        }else{
            $userId = Auth::user()->id;
            return $query->whereHas('users', function($users) use($userId) {
                $users->where('id', $userId);
            });
        }
    }

    //TODO: scopeEditable to prevent office admins from editing

    public function age() {
        if ($this->athletes->count()< 1) {
            return '-';
        }

        $minAge = $this->athletes->max('birth')->age;
        $maxAge = $this->athletes->min('birth')->age;

        if ($minAge == $maxAge) {
            return $minAge;
        }

        return $minAge . ' - ' . $maxAge;
    }

    public function sex() {
        if ($this->athletes->count()< 1) {
            return '-';
        }

        $m = $this->athletes->contains('sex', Sex::MALE);
        $f = $this->athletes->contains('sex', Sex::FEMALE);

        if ($m && $f) {
            return 'Gemischt';
        }

        if ($m) {
            return 'Männlich';
        }

        if ($f) {
            return 'Weiblich';
        }

        return '-';
    }

}
