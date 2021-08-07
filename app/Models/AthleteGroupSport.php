<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Agilo\AthleteGroupSport
 *
 * @property integer $id
 * @property string $i18n
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AthleteGroupSport whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AthleteGroupSport whereI18n($value)
 * @mixin \Eloquent
 */
class AthleteGroupSport extends Model
{
    const DEFAULT_SPORT_I18N = 'db.athlete.group.sport.default';

    public $timestamps = false;

    public function selected($oldId) {
        if ($oldId) {
            return $this->id == $oldId;
        }

        return $this->i18n == static::DEFAULT_SPORT_I18N;
    }
}
