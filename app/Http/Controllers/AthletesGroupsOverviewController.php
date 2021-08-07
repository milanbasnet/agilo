<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use App\Models\AthleteGroup;

class AthletesGroupsOverviewController extends Controller
{
    public function index()
    {
        $athletes = Athlete::visible()->get()->sortBy('last_name', SORT_NATURAL | SORT_FLAG_CASE);
        $groups = AthleteGroup::visible()->get()->sortBy('title', SORT_NATURAL | SORT_FLAG_CASE);

        return view('athletes-groups-overview.index', compact('athletes', 'groups'));
    }
}
