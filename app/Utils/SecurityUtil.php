<?php

namespace App\Utils;

use App\Models\AdminOffice;
use Auth;

class SecurityUtil
{
    /**
     * Returns a collection of the office ids used to fetch the workouts.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function officeIds()
    {
        return collect([
            AdminOffice::all()->first()->office_id,
            Auth::user()->office_id,
        ])->unique();
    }
}
