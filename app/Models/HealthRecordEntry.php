<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



/**
 * Agilo\HealthRecordEntry
 *
 * @property integer $id
 * @property integer $health_record_id
 * @property string $title
 * @property string $content
 * @property string $author
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Agilo\HealthRecord $healthRecord
 * @method static \Illuminate\Database\Query\Builder|\Agilo\HealthRecordEntry whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\HealthRecordEntry whereHealthRecordId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\HealthRecordEntry whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\HealthRecordEntry whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\HealthRecordEntry whereAuthor($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\HealthRecordEntry whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\HealthRecordEntry whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\HealthRecordEntry whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property integer $therapist_id
 * @property-read \Agilo\User $therapist
 * @method static \Illuminate\Database\Query\Builder|\Agilo\HealthRecordEntry whereTherapistId($value)
 * @property integer $user_id
 * @property-read \Agilo\User $user
 * @method static \Illuminate\Database\Query\Builder|\Agilo\HealthRecordEntry whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\HealthRecordEntry editable()
 */
class HealthRecordEntry extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'content'];

    public function healthRecord()
    {
        return $this->belongsTo('App\Models\HealthRecord');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function scopeEditable(Builder $query)
    {
        return $query->whereUserId(Auth::user()->id);
    }
}
