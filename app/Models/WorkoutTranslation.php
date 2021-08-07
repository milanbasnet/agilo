<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class WorkoutTranslation represents the counterpart for the database table workout_translations.
 *
 * @property integer $id
 * @property integer $workout_id
 * @property string $language_code
 * @property string $title
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Agilo\Workout $workout
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutTranslation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutTranslation whereWorkoutId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutTranslation whereLanguageCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutTranslation whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutTranslation whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutTranslation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutTranslation whereDeletedAt($value)
 * @mixin \Eloquent
 * @property string $starting_position
 * @property string $execution
 * @property string $hints
 * @property string $difficulty
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutTranslation whereStartingPosition($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutTranslation whereExecution($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutTranslation whereHints($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutTranslation whereDifficulty($value)
 * @property string $title_in_app
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutTranslation whereTitleInApp($value)
 */
class WorkoutTranslation extends Translation
{
    use SoftDeletes,HasFactory;

    protected $fillable = ['title', 'title_in_app', 'starting_position', 'execution', 'hints', 'difficulty'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

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
     * Returns the corresponding workout.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->workout();
    }
}
