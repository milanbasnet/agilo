<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Agilo\WorkoutUserEvent
 *
 * @property integer $id
 * @property integer $athlete_id
 * @property integer $parameterized_workout_id
 * @property integer $event_type
 * @property integer $client_time
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Agilo\Athlete $athlete
 * @property-read \Agilo\ParameterizedWorkout $paramWorkout
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutUserEvent whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutUserEvent whereAthleteId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutUserEvent whereParameterizedWorkoutId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutUserEvent whereEventType($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutUserEvent whereClientTime($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutUserEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutUserEvent whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WorkoutUserEvent extends Model
{
    protected $fillable = ['event_type'];

    protected $visible = ['event_type', 'created_at'];

    /**
     * Returns the corresponding athlete.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function athlete()
    {
        return $this->belongsTo('App\Models\Athlete');
    }

    /**
     * Returns the corresponding parameterized workout.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paramWorkout()
    {
        return $this->belongsTo('App\Models\ParameterizedWorkout', 'parameterized_workout_id');
    }

}
