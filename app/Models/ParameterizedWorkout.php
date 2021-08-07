<?php

namespace App\Models;

use App\Utils\TranslationUtil;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ParameterizedWorkout represents the counterpart for the database table parameterized_workouts.
 *
 * @property integer $id
 * @property integer $workout_id
 * @property integer $workout_routine_id
 * @property integer $sets
 * @property integer $repetitions
 * @property string $rest
 * @property string $holding_period
 * @property string $weight
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Agilo\Workout $workout
 * @property-read WorkoutRoutine $routine
 * @method static \Illuminate\Database\Query\Builder|\Agilo\ParameterizedWorkout whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\ParameterizedWorkout whereWorkoutId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\ParameterizedWorkout whereWorkoutRoutineId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\ParameterizedWorkout whereSets($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\ParameterizedWorkout whereRepetitions($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\ParameterizedWorkout whereRepetitionsSplitA($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\ParameterizedWorkout whereRepetitionsSplitB($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\ParameterizedWorkout whereRest($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\ParameterizedWorkout whereHoldingPeriod($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\ParameterizedWorkout whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\ParameterizedWorkout whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\ParameterizedWorkout whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\ParameterizedWorkout withTranslation()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Agilo\WorkoutUserEvent[] $workoutUserEvents
 */
class ParameterizedWorkout extends Model
{
    protected $fillable = ['sets', 'repetitions', 'rest', 'holding_period', 'weight'];

    /**
     * Returns the corresponding workout.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workout()
    {
        return $this->belongsTo('App\Models\Workout');
    }

    /**
     * Returns the corresponding routine.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function routine()
    {
        return $this->belongsTo('App\Models\WorkoutRoutine', 'workout_routine_id');
    }

    public function translations() {
        return $this->workout->translations();
    }

    public function scopeWithTranslation(Builder $query)
    {
        return $query->whereHas('workout.translations', TranslationUtil::closure())
            ->with(['workout.translations' => TranslationUtil::closure()]);
    }

    public function workoutUserEvents(){
        return $this->hasMany('App\Models\WorkoutUserEvent');
    }

}
