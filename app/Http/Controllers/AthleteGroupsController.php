<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use App\Models\AthleteGroup;
use App\Models\Office;
use App\Models\AssignedRoutine;
use App\Models\WorkoutRoutine;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;


/**
 * TODO: phpdoc
 * Class AthleteGroupsController
 * @package Agilo\Http\Controllers
 */
class AthleteGroupsController extends Controller
{
    public function show($id)
    {
        $group = AthleteGroup::visible()
            ->with('athletes', 'users')
            ->findOrFail($id);

        $assignedRoutines = AssignedRoutine::where('group_id',$group->id)->with('routine.translations')->get();

        return view('athletegroups.show', compact('group', 'assignedRoutines'));
    }

    public function create()
    {
        return view('athletegroups.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'sport' => 'required|integer|exists:athlete_group_sports,id',
            'level' => 'required|integer|exists:athlete_group_levels,id',
            'workouts_per_week' => 'required|integer|between:1,14',
            'users' => 'required|max:5|therapists',
        ], [
            'title.required' => 'Geben Sie einen Namen ein.'
        ]);

        $group = new AthleteGroup($request->input());

        $group->office_id = Auth::user()->office_id;
        $group->sport_id = $request->input('sport');
        $group->level_id = $request->input('level');

        $group->save();

        $group->users()->sync($request->input('users'));

        return redirect()->action('App\Http\Controllers\AthleteGroupsController@show', [ $group->id ]);
    }

    public function edit($id)
    {
        $group = AthleteGroup::visible()->findOrFail($id);

        $this->flash($group);

        return view('athletegroups.edit', compact('group'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'sport' => 'required|integer|exists:athlete_group_sports,id',
            'level' => 'required|integer|exists:athlete_group_levels,id',
            'workouts_per_week' => 'required|integer|between:1,14',
            'users' => 'required|max:5|therapists',
        ], [
            'title.required' => 'Geben Sie einen Namen ein.'
        ]);
        $group = AthleteGroup::visible()->findOrFail($id);

        $group->fill($request->input());

        $group->sport_id = $request->input('sport');
        $group->level_id = $request->input('level');

        $group->save();

        $group->users()->sync($request->input('users'));

        return redirect()->action('App\Http\Controllers\AthleteGroupsController@show', [ $group->id ]);
    }

    private function flash($group)
    {
        $flash = [
            'title' => old('title', $group->title),
            'description' => old('description', $group->description),
            'workouts_per_week' => old('workouts_per_week', $group->workouts_per_week),
            'sport' => old('sport', $group->sport_id),
            'level' => old('level', $group->level_id),
            'users' => old('users', $group->userIds()),
        ];

        Session::flashInput($flash);
    }

    public function destroy($id)
    {
        AthleteGroup::visible()->findOrFail($id)->delete();

        return redirect()->action('App\Http\Controllers\AthletesGroupsOverviewController@index');
    }

    public function athletes($id)
    {
        $group = AthleteGroup::visible()
            ->with('athletes')
            ->findOrFail($id);

        $athletes = Athlete::visible()->where('active',1)
            ->get()
            ->diff($group->athletes);

        return view('athletegroups.athletes-overview', compact('group', 'athletes'));
    }

    public function assign_athlete(Request $request, $id)
    {
        $group = AthleteGroup::visible()
            ->with('athletes')
            ->findOrFail($id);

        $athlete_id = $request->input('athlete');

        $athlete = Athlete::visible()
            ->find($athlete_id);

        if ($athlete && !$group->athletes->contains('id', $athlete_id)) {
            $group->athletes()->attach($athlete_id);
        }

        return redirect()->action('App\Http\Controllers\AthleteGroupsController@athletes', [ $group->id ]);
    }

    public function unassign_athlete(Request $request, $id)
    {
        $group = AthleteGroup::visible()
            ->with('athletes')
            ->findOrFail($id);

        $group->athletes()->detach($request->input('athlete'));

        return redirect()->action('App\Http\Controllers\AthleteGroupsController@athletes', [ $group->id ]);
    }

    public function routines($id)
    {
        $group = AthleteGroup::visible()->findOrFail($id);

        $availableRoutines = WorkoutRoutine::withTranslation()->visible()->get();

        $assignedRoutines = AssignedRoutine::with('routine.translations')->where('group_id',$group->id)->get();

        $minDate = Carbon::now();
        $maxDate = Carbon::now()->addYear();

        return view('athletegroups.routines-overview', compact('group', 'availableRoutines', 'assignedRoutines', 'minDate', 'maxDate'));
    }

    public function assign_routine(Request $request, $id)
    {
        $group = AthleteGroup::visible()
            //->with('routines')
            ->findOrFail($id);

        $routine_id = $request->input('routine');

        $routineTemplate = WorkoutRoutine::visible()
            ->find($routine_id);


        //TODO: check if routineTemplate is already used?
        //TODO: use in transaction

        $assignedRoutine = new AssignedRoutine(['duration' => $routineTemplate->duration_default, 'frequence' => $routineTemplate->frequence_default]);
        $assignedRoutine->routine()->associate($routineTemplate);
        $assignedRoutine->group()->associate($group);

        //setting start_date implicitly to tomorrow
        $assignedRoutine->start_date = Carbon::tomorrow();

        $assignedRoutine->save();


        return redirect()->action('App\Http\Controllers\AthleteGroupsController@routines', [ $group->id ]);
    }

    public function unassign_routine(Request $request, $id)
    {
        $group = AthleteGroup::visible()
            ->findOrFail($id);

        $assignedRoutine = AssignedRoutine::findOrFail($request->input('assignedRoutine'));

        $assignedRoutine->delete();

        return redirect()->action('App\Http\Controllers\AthleteGroupsController@routines', [ $group->id ]);
    }

    public function update_assigned_routine(Request $request, $id)
    {
        $group = AthleteGroup::visible()
            ->findOrFail($id);

        $assignedRoutine = AssignedRoutine::where('group_id',$group->id)->findOrFail($request->input('assignedRoutine'));

        //TODO validate input values
        //TODO modify and save in a single transaction
        $assignedRoutine->duration = $request->input('duration');
        $assignedRoutine->start_date = $request->input('start_date');
        $assignedRoutine->frequence = $request->input('frequence');

        $assignedRoutine->save();

        return redirect()->action('App\Http\Controllers\AthleteGroupsController@routines', [ $group->id ]);
    }
}