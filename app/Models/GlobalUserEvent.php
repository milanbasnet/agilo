<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalUserEvent extends Model
{
    protected $fillable = ['event_type', 'data'];

    protected $visible = ['event_type', 'data', 'client_time', 'created_at'];

    /**
     * Returns the corresponding athlete.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function athlete()
    {
        return $this->belongsTo('App\Models\Athlete');
    }
}
