<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Agilo\LevelTag
 *
 * @property integer $id
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\Agilo\LevelTag whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\LevelTag whereName($value)
 * @mixin \Eloquent
 */
class LevelTag extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];
}
