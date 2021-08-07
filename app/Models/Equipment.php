<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Agilo\Equipment
 *
 * @property integer $id
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Equipment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Equipment whereName($value)
 * @mixin \Eloquent
 */
class Equipment extends Model{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'equipments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];


    public $timestamps = false;
}