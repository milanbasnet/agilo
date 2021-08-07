<?php

namespace App\Models;

use App\Utils\EditableTrait;
use App\Utils\SecurityUtil;
use App\Utils\TranslationUtil;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use File;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * Class Workout represents the counterpart for the database table workouts.
 *
 * @property integer $id
 * @property integer $office_id
 * @property string $image_path
 * @property integer $type
 * @property boolean $equipment_needed
 * @property boolean $repetitions_split
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Agilo\WorkoutTag[] $tags
 * @property-read \Illuminate\Database\Eloquent\Collection|\Agilo\WorkoutTranslation[] $translations
 * @property-read \Agilo\Office $office
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Workout whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Workout whereOfficeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Workout whereImagePath($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Workout whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Workout whereEquipmentNeeded($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Workout whereRepetitionsSplit($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Workout whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Workout whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Workout whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Workout withTranslation()
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Workout editable()
 * @property integer $video_id
 * @property-read \Agilo\Video $video
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Workout whereVideoId($value)
 * @mixin \Eloquent
 * @property integer $sets_default
 * @property integer $rest_default
 * @property float $weight_default
 * @property integer $repetitions_default
 * @property integer $holding_period_default
 * @property string $material
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Workout whereSetsDefault($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Workout whereRestDefault($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Workout whereWeightDefault($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Workout whereRepetitionsDefault($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Workout whereHoldingPeriodDefault($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Workout whereMaterial($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Workout visible()
 * @property integer $equipment_id
 * @property integer $pace_tag_id
 * @property-read \Agilo\Equipment $equipment
 * @property-read \Illuminate\Database\Eloquent\Collection|\Agilo\RegionTag[] $regionTags
 * @property-read \Illuminate\Database\Eloquent\Collection|\Agilo\TypeTag[] $typeTags
 * @property-read \Agilo\PaceTag $paceTag
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Workout whereEquipmentId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Workout wherePaceTagId($value)
 * @property integer $level_tag_id
 * @property-read \Agilo\LevelTag $levelTag
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Workout whereLevelTagId($value)
 */
class Workout extends TranslationParent
{
    use SoftDeletes, EditableTrait,HasFactory;

    /**
     * The fields which can be used for mass assignment.
     *
     * @var array
     */
    protected $fillable = ['type', 'rest_default', 'sets_default', 'weight_default', 'repetitions_default', 'holding_period_default', 'material'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['office', 'translations', 'tags', 'office_id', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * Returns the associated workout tags.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Models\WorkoutTag')->withTimestamps();
    }

    /**
     * Returns the associated workout translations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translations()
    {
        return $this->hasMany('App\Models\WorkoutTranslation');
    }

    /**
     * Returns the associated office.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function office()
    {
        return $this->belongsTo('App\Models\Office');
    }

    public function equipment()
    {
        return $this->belongsTo('App\Models\Equipment');
    }

    public function regionTags()
    {
        return $this->belongsToMany('App\Models\RegionTag');
    }

    public function typeTags(){
        return $this->belongsToMany('App\Models\TypeTag');
    }

    public function paceTag(){
        return $this->belongsTo('App\Models\PaceTag');
    }

    public function levelTag(){
        return $this->belongsTo('App\Models\LevelTag');
    }

    /**
     * Load workouts with the translation for the current locale, if a translation exists.
     *
     * @param Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithTranslation(Builder $query)
    {
        return $query->whereHas('translations', TranslationUtil::closure())
                    ->with(['translations' => TranslationUtil::closure()]);
    }

    /**
     * Load the workouts of the current office.
     *
     * @param Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEditable(Builder $query)
    {
        return $query->whereOfficeId(Auth::user()->office_id);
    }

    /**
     * Load the workouts of the current office and admin office.
     *
     * @param Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisible(Builder $query)
    {
        return $query->whereIn('office_id', SecurityUtil::officeIds());
    }

    /**
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public static function boot ()
    {
        parent::boot();

        static::deleting(function($workout)
        {
            $video = $workout->video;

            if ($video) {
                if (File::exists(('/storage/'.$video->path))) {
                    File::delete(storage_path('/app/public/'.$video->path));
                }

                if (File::exists(storage_path('/app/public/'.$video->thumbnail_path))) {
                    File::delete(storage_path('/app/public/'.$video->thumbnail_path));
                }
            }
        });
    }

    private function mapToId(Collection $collection) {
        return $collection->map(function ($item) {
            return $item->id;
        });
    }

    public function regionIds()
    {
        return $this->mapToId($this->regionTags)->all();
    }

    public function regionIdsAsJson()
    {
        return $this->mapToId($this->regionTags)->toJson();
    }

    public function typeIds()
    {
        return $this->mapToId($this->typeTags)->all();
    }

    public function typeIdsAsJson()
    {
        return $this->mapToId($this->typeTags)->toJson();
    }

    public function levelIdAsJson()
    {
        return collect($this->levelTag->id)->toJson();
    }

    public function equipmentIdAsJson()
    {
        if ($this->equipment) {
            return collect($this->equipment->id)->toJson();
        } else {
            return collect()->toJson();
        }
    }
}
