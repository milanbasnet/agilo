<?php

namespace App\Models;

use App\Utils\EditableTrait;
use App\Utils\TranslationUtil;
use App\Utils\SecurityUtil;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Class WorkoutRoutine represents the counterpart for the database table workout routines.
 *
 * @property integer $id
 * @property integer $office_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Agilo\Office $office
 * @property-read \Illuminate\Database\Eloquent\Collection|\Agilo\WorkoutRoutineTranslation[] $translations
 * @property-read \Illuminate\Database\Eloquent\Collection|\Agilo\ParameterizedWorkout[] $parameterizedWorkouts
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutine whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutine whereOfficeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutine whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutine whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutine whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutine withTranslation()
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutine own()
 * @mixin \Eloquent
 * @property integer $user_id
 * @property integer $frequence_default
 * @property integer $duration_default
 * @property string $pubmed_link
 * @property integer $age_tag_id
 * @property integer $gender_tag_id
 * @property integer $measure_tag_id
 * @property-read \Agilo\User $user
 * @property-read \Agilo\MeasureTag $measureTag
 * @property-read \Agilo\AgeTag $ageTag
 * @property-read \Agilo\GenderTag $genderTag
 * @property-read \Illuminate\Database\Eloquent\Collection|\Agilo\ObjectiveTag[] $objectiveTags
 * @property-read \Illuminate\Database\Eloquent\Collection|\Agilo\RegionTag[] $regionTags
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutine whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutine whereFrequenceDefault($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutine whereDurationDefault($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutine wherePubmedLink($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutine whereAgeTagId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutine whereGenderTagId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutine whereMeasureTagId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutine visible()
 * @property integer $level_tag_id
 * @property-read \Agilo\LevelTag $levelTag
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutine whereLevelTagId($value)
 * @property integer $objective_tag_id
 * @property-read \Agilo\ObjectiveTag $objectiveTag
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutine whereObjectiveTagId($value)
 * @property-read \Agilo\AthleteGroupSport $sport
 * @property integer $sport_id
 * @method static \Illuminate\Database\Query\Builder|\Agilo\WorkoutRoutine whereSportId($value)
 */
class WorkoutRoutine extends TranslationParent
{
    use SoftDeletes, EditableTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = ['frequence_default', 'duration_default', 'pubmed_link'];

    /**
     * Returns the associated office.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function office()
    {
        return $this->belongsTo('App\Models\Office');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function measureTag()
    {
        return $this->belongsTo('App\Models\MeasureTag');
    }

    public function ageTag(){
        return $this->belongsTo('App\Models\AgeTag');
    }

    public function genderTag(){
        return $this->belongsTo('App\Models\GenderTag');
    }

    public function sport(){
        return $this->belongsTo('App\Models\AthleteGroupSport', 'sport_id');
    }

    public function objectiveTag(){
        return $this->belongsTo('App\Models\ObjectiveTag');
    }

    public function regionTags(){
        return $this->belongsToMany('App\Models\RegionTag');
    }

    public function levelTag(){
        return $this->belongsTo('App\Models\LevelTag');
    }


    /**
     * Returns the associated workout routine translations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translations()
    {
        return $this->hasMany('App\Models\WorkoutRoutineTranslation');
    }

    /**
     * Returns the associated parameterized workouts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parameterizedWorkouts()
    {
        return $this->hasMany('App\Models\ParameterizedWorkout');
    }

    /**
     * Load workout routines with the translation for the current locale, if a translation exists.
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
     * Only load the workout routines for the own office.
     *
     * @param Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOwn(Builder $query)
    {
        return $query->where('office_id', \Auth::user()->office_id);
    }

    /**
     * Loads WorkoutRoutines of own office and adminoffice
     * @param Builder $query
     * @return mixed
     */
    public function scopeVisible(Builder $query)
    {
        return $query->whereIn('office_id', SecurityUtil::officeIds());
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

    public function measureIdAsJson()
    {
        return collect($this->measureTag->id)->toJson();
    }

    public function objectiveIdAsJson()
    {
        return collect($this->objectiveTag->id)->toJson();
    }

    public function sportIdAsJson()
    {
        return collect($this->sport->id)->toJson();
    }

    public function genderIdAsJson()
    {
        return collect($this->genderTag->id)->toJson();
    }

    public function ageIdAsJson()
    {
        return collect($this->ageTag->id)->toJson();
    }
}
