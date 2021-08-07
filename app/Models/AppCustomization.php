<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AppCustomization represents the counterpart for the database table app_customizations.
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AppCustomization whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AppCustomization whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AppCustomization whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AppCustomization extends Model
{
    //
}
