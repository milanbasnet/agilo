<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Agilo\TherapistRole
 *
 * @property integer $id
 * @property string $i18n
 * @method static \Illuminate\Database\Query\Builder|\Agilo\TherapistRole whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\TherapistRole whereI18n($value)
 * @mixin \Eloquent
 */
class TherapistRole extends Model
{
    public $timestamps = false;
}
