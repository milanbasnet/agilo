<?php

namespace App\Http\Controllers;

use App\Models\AssignedRoutine;
use App\Models\Athlete;
use App\Models\HealthRecord;
use App\Services\Mailer;
use App\Models\WorkoutRoutine;
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use LaravelLocalization;
use Illuminate\Support\Str;


/**
 * TODO: phpdoc
 * Class AthletesController
 * @package Agilo\Http\Controllers
 */
class AthletesController extends Controller
{
    public function show($id)
    {
        $athlete = Athlete::visible()->with('groups')->findOrFail($id);

        $assignedRoutines = AssignedRoutine::where('athlete_id',$athlete->id)->with('routine.translations')->get();

        $groupIds = collect($athlete->groups->map(function($group) {
            return $group->id;
        }));

        $assignedRoutinesByGroup = AssignedRoutine::whereIn('group_id',$groupIds)->with('routine.translations')->get();

        return view('athletes.show', compact('athlete', 'assignedRoutines', 'assignedRoutinesByGroup'));
    }

    public function create()
    {
        $minDate = Carbon::now()->subYears(100);
        $maxDate = Carbon::now()->subYears(5);

        return view('athletes.create', compact('minDate', 'maxDate'));
    }

    public function store(Request $request, Mailer $mailer)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'birth' => 'required|date',
            'email' => 'required|email|unique:athletes'
        ]);

        $athlete = new Athlete($request->input());
        $athlete->language_code = LaravelLocalization::getCurrentLocale();

        $password = Str::random(10);
        $athlete->password = Hash::make($password);
        $athlete->office_id = Auth::user()->office_id;

        $athlete->save();

        $healthRecord = new HealthRecord();
        $healthRecord->athlete()->associate($athlete);
        $healthRecord->save();

        $mailer->send('athlete-created',
            ['athlete' => $athlete, 'password' => $password],
            function ($message) use ($athlete) {
                $message->to($athlete->email)->subject(trans('subjects.athlete-created'));
            }
        );

        return redirect()->action('App\Http\Controllers\AthletesController@show', [$athlete->id]);
    }

    public function activate($id)
    {
        $athlete = Athlete::visible()->findOrFail($id);
        $athlete->active = true;
        $athlete->save();

        return redirect()->action('App\Http\Controllers\AthletesController@show', [ $athlete->id ]);
    }

    public function deactivate($id)
    {
        $athlete = Athlete::visible()->findOrFail($id);
        $athlete->active = false;
        $athlete->save();

        return redirect()->action('App\Http\Controllers\AthletesController@show', [ $athlete->id ]);
    }

    public function routines($id)
    {
        $athlete = Athlete::visible()->findOrFail($id);

        $availableRoutines = WorkoutRoutine::withTranslation()->visible()->get();

        $assignedRoutines = AssignedRoutine::with('routine.translations')->where('athlete_id',$athlete->id)->get();

        $minDate = Carbon::now();
        $maxDate = Carbon::now()->addYear();

        return view('athletes.routines-overview', compact('athlete', 'availableRoutines', 'assignedRoutines', 'minDate', 'maxDate'));
    }

    public function assign_routine(Request $request, $id)
    {
        $athlete = Athlete::visible()
            //->with('routines')
            ->findOrFail($id);

        $routine_id = $request->input('routine');

        $routineTemplate = WorkoutRoutine::visible()
            ->find($routine_id);

        //TODO: check if routineTemplate is already used?
        //TODO: use in transaction

        $assignedRoutine = new AssignedRoutine(['duration' => $routineTemplate->duration_default, 'frequence' => $routineTemplate->frequence_default]);
        $assignedRoutine->routine()->associate($routineTemplate);
        $assignedRoutine->athlete()->associate($athlete);

        //setting start_date implicitly to tomorrow
        $assignedRoutine->start_date = Carbon::tomorrow();

        $assignedRoutine->save();


        return redirect()->action('App\Http\Controllers\AthletesController@routines', [ $athlete->id ]);
    }

    public function unassign_routine(Request $request, $id)
    {
        $athlete = Athlete::visible()
            ->findOrFail($id);

        $assignedRoutine = AssignedRoutine::findOrFail($request->input('assignedRoutine'));

        $assignedRoutine->delete();

        return redirect()->action('App\Http\Controllers\AthletesController@routines', [ $athlete->id ]);
    }

    public function update_assigned_routine(Request $request, $id)
    {
        $athlete = Athlete::visible()
            ->findOrFail($id);

        $assignedRoutine = AssignedRoutine::where('athlete_id',$athlete->id)->findOrFail($request->input('assignedRoutine'));

        //TODO validate input values
        //TODO modify and save in a single transaction
        $assignedRoutine->duration = $request->input('duration');
        $assignedRoutine->start_date = $request->input('start_date');
        $assignedRoutine->frequence = $request->input('frequence');

        $assignedRoutine->save();

        return redirect()->action('App\Http\Controllers\AthletesController@routines', [ $athlete->id ]);
    }



 
}