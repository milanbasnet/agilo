<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class WorkoutRoutineTranslation represents the counterpart for the database table workout_routine_translations.
 *
 * @property integer $id
 * @property integer $workout_routine_id
 * @property string $language_code
 * @property string $title_internal
 * @property string $title_external
 * @property string $description_internal
 * @property string $description_external
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Agilo\WorkoutRoutine $routine
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutineTranslation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutineTranslation whereWorkoutRoutineId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutineTranslation whereLanguageCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutineTranslation whereTitleInternal($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutineTranslation whereTitleExternal($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutineTranslation whereDescriptionInternal($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutineTranslation whereDescriptionExternal($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutineTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutineTranslation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutineTranslation whereDeletedAt($value)
 * @mixin \Eloquent
 * @property string $title
 * @property string $description
 * @property string $injuries
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutineTranslation whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutineTranslation whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutineTranslation whereInjuries($value)
 */
class WorkoutRoutineTranslation extends Translation
{
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'injuries'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Returns the corresponding workout routine.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function routine()
    {
        return $this->belongsTo('App\Models\WorkoutRoutine', 'workout_routine_id');
    }

    /**
     * Returns the corresponding routine.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->routine();
    }
}
