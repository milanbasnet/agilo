<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

/**
 * Agilo\Video
 *
 * @property integer $id
 * @property string $name
 * @property string $path
 * @property string $thumbnail_path
 * @property-read \Agilo\Workout $workout
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Video whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Video whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Video wherePath($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Video whereThumbnailPath($value)
 * @mixin \Eloquent
 */
class Video extends Model
{
    use HasFactory;
    /**
     * Fillable fields for mass assignment.
     *
     * @var array
     */
    protected $fillable = ['name', 'path', 'thumbnail_path'];

    public $timestamps = false;

    /**
     *
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function workout()
    {
        return $this->hasOne(Workout::class);
    }
}
