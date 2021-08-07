<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Agilo\OfficeType
 *
 * @property integer $id
 * @property string $i18n
 * @method static \Illuminate\Database\Query\Builder|\Agilo\OfficeType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\OfficeType whereI18n($value)
 * @mixin \Eloquent
 */
class OfficeType extends Model
{
    public $timestamps = false;
}
