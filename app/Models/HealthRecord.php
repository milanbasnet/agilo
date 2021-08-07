<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HealthRecord represents the counterpart for the table health_records.
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Agilo\HealthRecord whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\HealthRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\HealthRecord whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property integer $athlete_id
 * @property-read \Agilo\Athlete $athlete
 * @property-read \Illuminate\Database\Eloquent\Collection|\Agilo\HealthRecordEntry[] $entries
 * @method static \Illuminate\Database\Query\Builder|\Agilo\HealthRecord whereAthleteId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\HealthRecord withEntries()
 */
class HealthRecord extends Model
{
    public function athlete()
    {
        return $this->belongsTo('App\Models\Athlete');
    }


    public function entries()
    {
        return $this->hasMany('App\Models\HealthRecordEntry')
            ->orderBy('updated_at', 'desc');
    }

    /**
     * Load record with the entries.
     *
     * @param Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithEntries(Builder $query)
    {
        return $query->with('entries');
    }
}
