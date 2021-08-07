<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Agilo\AssignedRoutine
 *
 * @property integer $id
 * @property integer $frequence
 * @property integer $duration
 * @property string $start_date
 * @property integer $routine_id
 * @property integer $group_id
 * @property integer $athlete_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Agilo\WorkoutRoutine $routine
 * @property-read \Agilo\AthleteGroup $group
 * @property-read \Agilo\Athlete $athlete
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AssignedRoutine whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AssignedRoutine whereFrequence($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AssignedRoutine whereDuration($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AssignedRoutine whereStartDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AssignedRoutine whereRoutineId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AssignedRoutine whereGroupId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AssignedRoutine whereAthleteId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AssignedRoutine whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AssignedRoutine whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AssignedRoutine extends Model
{
    protected $dates = ['start_date'];

    protected $fillable = ['frequence','duration','start_date'];

    public function routine()
    {
        return $this->belongsTo('App\Models\WorkoutRoutine');
    }

    public function group()
    {
        return $this->belongsTo('App\Models\AthleteGroup');
    }

    public function athlete()
    {
        return $this->belongsTo('App\Models\Athlete');
    }

    public function events(){
        return $this->hasMany('App\Models\WorkoutRoutineEvent');
    }

    /**
     * @return true if start_date + duration(weeks) is < today
     */
    public function isArchived()
    {
        $endDate = Carbon::parse($this->start_date)->addWeeks($this->duration);
        $today = Carbon::today();

        return $today->gt($endDate);
    }

    public function isActive(){
        $today = Carbon::today();
        $startDate = Carbon::parse($this->start_date);
        return $today->gte($startDate) && !$this->isArchived();
    }

    public function getFormattedStartDate(){
        return Carbon::parse($this->start_date)->format("Y-m-d");
    }
}
