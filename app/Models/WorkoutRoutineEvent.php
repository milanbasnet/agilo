<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutRoutineEvent extends Model
{
    protected $fillable = ['event_type'];

    protected $visible = ['event_type', 'client_time', 'created_at'];

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
    public function assignedRoutine()
    {
        return $this->belongsTo('App\Models\AssignedRoutine', 'assigned_routine_id');
    }
}
