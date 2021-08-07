<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WorkoutTag represents the counterpart for the database table workout_tags.
 *
 * @property integer $id
 * @property string $title
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Agilo\Workout[] $workouts
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutTag whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutTag whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutTag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WorkoutTag extends Model
{

    protected $fillable = ['title'];
    /**
     * Returns the associated workouts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function workouts()
    {
        return $this->belongsToMany('App\Models\Workout');
    }
}
