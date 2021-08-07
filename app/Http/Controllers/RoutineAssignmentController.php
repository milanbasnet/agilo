<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use App\Models\AthleteGroup;
use App\Models\WorkoutRoutine;
use Illuminate\Http\Request;

class RoutineAssignmentController extends Controller
{
    public function assign($id, Request $request)
    {
        $athlete = Athlete::visible()->findOrFail($id);

        $currentlyAssigned = collect($athlete->routines->map(function ($item) {
            return $item->id;
        }));

        if ($request->has('routines')) {
            $routineIds = $request->input('routines');

            $routines = WorkoutRoutine::own()->whereIn('id', $routineIds)->get();

            $routines->each(function ($routine) use ($athlete, $currentlyAssigned) {
                $key = $currentlyAssigned->search($routine->id);

                if ($key !== false) {
                    $currentlyAssigned->forget($key);
                } else {
                    $athlete->routines()->attach($routine->id);
                }
            });
        }

        $currentlyAssigned->each(function ($routineId) use ($athlete) {
            $athlete->routines()->detach($routineId);
        });

        return redirect()->action('App\Http\Controllers\AthletesController@show', [$athlete->id]);
    }

    /**
     * Assigns a bunch of routines to a group
     * @param $id id of the current group
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assign_group($id, Request $request)
    {
        $group = AthleteGroup::visible()->findOrFail($id);

        $currentlyAssigned = collect($group->routines->map(function ($item) {
            return $item->id;
        }));

        if ($request->has('routines')) {
            $routineIds = $request->input('routines');

            $routines = WorkoutRoutine::own()->whereIn('id', $routineIds)->get();

            $routines->each(function ($routine) use ($group, $currentlyAssigned) {
                $key = $currentlyAssigned->search($routine->id);

                if ($key !== false) {
                    $currentlyAssigned->forget($key);
                } else {
                    $group->routines()->attach($routine->id);
                }
            });
        }

        $currentlyAssigned->each(function ($routineId) use ($group) {
            $group->routines()->detach($routineId);
        });

        return redirect()->action('App\Http\Controllers\AthleteGroupsController@show', [$group->id]);
    }
}
