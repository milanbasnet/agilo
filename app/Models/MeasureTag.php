<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Agilo\TypeTag
 *
 * @property integer $id
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\Agilo\TypeTag whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\TypeTag whereName($value)
 * @mixin \Eloquent
 */
class MeasureTag extends Model
{
    protected $fillable = ['name'];

    public $timestamps = false;
}
