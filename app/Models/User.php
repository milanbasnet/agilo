<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'recovery_code',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


     /**
     * Returns the associated office.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function office()
    {
        return $this->belongsTo('App\Models\Office');
    }

    /**
     * Returns the assigned role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function therapistRole() {
        return $this->belongsTo('App\Models\TherapistRole');
    }

    /**
     * Returns the assigned role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups() {
        return $this->belongsToMany('App\Models\AthleteGroup');
    }

    public function groupNames() {
        return $this->groups
            ->map(function ($item) {
                return $item->title;
            })
            ->implode(', ');
    }

    /**
     * Is user in role 'admin'?
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role->name == 'admin';
    }

    /**
     * Is user in role 'office-admin'?
     *
     * @return bool
     */
    public function isOfficeAdmin()
    {
        return $this->role->name == 'office-admin';
    }

    // TODO: move roles to enum
    public function isTherapist()
    {
        return $this->role->name == 'therapist';
    }

    /**
     * @param Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithRole(Builder $query)
    {
        return $query->with('role');
    }
}
