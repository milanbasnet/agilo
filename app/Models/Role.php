<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Role represents the counterpart for the database table roles.
 * 
 * Roles are used for access control mechanics. Following roles exist:
 * <li>admin - administrator of the system</li>
 * <li>office-admin - administrator of an office</li>
 * <li>therapist - therapist of an office</li>
 * <li>trial - for test accounts to get an overview of the system</li>.
 *
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Role whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Role whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Agilo\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends Model
{
    /**
     * Fillable fields for mass assignment.
     *
     * @var array
     */
    protected $fillable = ['name'];
}
