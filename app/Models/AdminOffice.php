<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminOffice
 * Used to query all admin offices.
 *
 * @property integer $id
 * @property integer $office_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Office $office
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AdminOffice whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AdminOffice whereOfficeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AdminOffice whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\AdminOffice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AdminOffice extends Model
{
    /**
     * Returns the associated office.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
