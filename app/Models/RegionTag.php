<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Agilo\RegionTag
 *
 * @property integer $id
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\Agilo\RegionTag whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\RegionTag whereName($value)
 * @mixin \Eloquent
 */
class RegionTag extends Model
{
    protected $fillable = ['name'];

    protected $visible = ['name'];

    public $timestamps = false;
}
