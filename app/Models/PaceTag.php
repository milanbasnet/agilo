<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Agilo\PaceTag
 *
 * @property integer $id
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\Agilo\PaceTag whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\PaceTag whereName($value)
 * @mixin \Eloquent
 */
class PaceTag extends Model
{
    protected $fillable = ['name'];

    public $timestamps = false;
}
