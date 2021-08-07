<?php

namespace App\Http\Controllers;

use App\Models\AgeTag;
use App\Models\GenderTag;
use App\Http\Requests\RoutineRequest;
use App\Models\LevelTag;
use App\Models\MeasureTag;
use App\Models\ObjectiveTag;
use App\Models\RegionTag;
use App\Utils\TranslationUtil;
use App\Models\ParameterizedWorkout;
use App\Models\Workout;
use App\Models\WorkoutRoutine;
use App\Models\WorkoutRoutineTranslation;
use Auth;
use DB;
use Illuminate\Support\MessageBag;
use Log;
use Session;
use Illuminate\Http\Request;

class RoutinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $routines = WorkoutRoutine::withTranslation()
            ->visible()
            ->get()
            ->sortByDesc('created_at');

        return view('routines.index', compact('routines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('routines.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RoutineRequest  $request
     * @return Response
     */
    public function store(RoutineRequest $request)
    {
        $routine = new WorkoutRoutine($request->input());
        $routine->office()->associate(Auth::user()->office);
        $routine->user()->associate(Auth::user());
        $routine->age_tag_id = $request->input('age');
        $routine->gender_tag_id = $request->input('gender');
        $routine->measure_tag_id = $request->input('measure');
        $routine->sport_id = $request->input('sport');
        $routine->objective_tag_id = $request->input('objective');
        $routine->level_tag_id = $request->input('level');

        try {
            DB::transaction(function() use ($request, $routine) {
                $routine->save();

                if ($request->exists('regions')) {
                    $routine->regionTags()->sync($request->input('regions'));
                }

                TranslationUtil::create($request, $routine, WorkoutRoutineTranslation::class);
            });
        } catch (\Exception $e) {
            Log::error($e->__toString());
            $errors = new MessageBag();
            $errors->add('Unerwarteter Fehler', 'Es ist ein unerwateter Fehler aufgetreten.');
            return redirect()->back()->withErrors($errors);
        }

        return redirect()->action('App\Http\Controllers\RoutinesController@show', [$routine->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $routine = WorkoutRoutine::withTranslation()
            ->visible()
            ->findOrFail($id);

        return view('routines.show', compact('routine'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $routine = WorkoutRoutine::with('translations')
            ->own()
            ->findOrFail($id);

        $this->flash($routine);

        return view('routines.edit', compact('routine'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RoutineRequest  $request
     * @param  int  $id
     * @return Response
     */
    public function update(RoutineRequest $request, $id)
    {
        $routine = WorkoutRoutine::own()->findOrFail($id);
        $routine->fill($request->input());
        $routine->age_tag_id = $request->input('age');
        $routine->gender_tag_id = $request->input('gender');
        $routine->measure_tag_id = $request->input('measure');
        $routine->sport_id = $request->input('sport');
        $routine->objective_tag_id = $request->input('objective');
        $routine->level_tag_id = $request->input('level');

        try {
            DB::transaction(function() use ($request, $routine) {
                $routine->save();

                if ($request->exists('regions')) {
                    $routine->regionTags()->sync($request->input('regions'));
                }

                TranslationUtil::update($request, $routine, WorkoutRoutineTranslation::class, true);
            });
        } catch (\Exception $e) {
            Log::error($e->__toString());
            $errors = new MessageBag();
            $errors->add('Unerwarteter Fehler', 'Es ist ein unerwateter Fehler aufgetreten.');
            return redirect()->action('App\Http\Controllers\RoutinesController@index')->withErrors($errors);
        }

        return redirect()->action('App\Http\Controllers\RoutinesController@show', [$routine->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        WorkoutRoutine::own()
            ->findOrFail($id)->delete();

        return redirect()->action('App\Http\Controllers\RoutinesController@index');
    }


    /**
     * Flashes the given workout to the session.
     *
     * @param WorkoutRoutine $routine
     */
    private function flash(WorkoutRoutine $routine)
    {
        $flash = [
            'duration_default' => old('duration_default', $routine->duration_default),
            'frequence_default' => old('frequence_default', $routine->frequence_default),
            'measure' => old('measure', $routine->measure_tag_id),
            'gender' => old('gender', $routine->gender_tag_id),
            'age' => old('age', $routine->age_tag_id),
            'sport' => old('sport', $routine->sport_id),
            'pubmed_link' => old('pubmed_link', $routine->pubmed_link),
            'regions' => old('regions', $routine->regionIds()),
            'objective' => old('objective', $routine->objective_tag_id),
            'level' => old('level', $routine->level_tag_id)
        ];

        $translations = $routine->translations;

        TranslationUtil::mergeFlash($translations, $flash, true);

        Session::flashInput($flash);
    }


    public function workouts($id)
    {
        $routine = WorkoutRoutine::own()
            ->findOrFail($id);

        $workouts = Workout::visible()->withTranslation()->get();

        return view('routines.workout-overview', compact('routine', 'workouts'));
    }

    public function assign(Request $request, $id)
    {
        $routine = WorkoutRoutine::own()
            ->findOrFail($id);

        $workout_id = $request->input('workout');

        $workout = Workout::visible()->withTranslation()->findOrFail($workout_id);

        //TODO: check if routineTemplate is already used?
        //TODO: use in transaction

        $paramWorkout = new ParameterizedWorkout();
        $paramWorkout->sets = $workout->sets_default;
        $paramWorkout->rest = $workout->rest_default;
        $paramWorkout->weight = $workout->weight_default;
        $paramWorkout->repetitions = $workout->repetitions_default;
        $paramWorkout->holding_period = $workout->holding_period_default;
        $paramWorkout->routine()->associate($routine);
        $paramWorkout->workout()->associate($workout);
        $paramWorkout->save();


        return redirect()->action('App\Http\Controllers\RoutinesController@workouts', [ $routine->id ]);
    }

    public function unassign(Request $request, $id)
    {

        $routine = WorkoutRoutine::own()
            ->findOrFail($id);

        $paramWorkout = $routine->parameterizedWorkouts()->findOrFail($request->input('paramWorkout'));
        $paramWorkout->delete();

        return redirect()->action('App\Http\Controllers\RoutinesController@workouts', [ $routine->id ]);
    }

    public function update_assigned_workout(Request $request, $id)
    {
        $routine = WorkoutRoutine::own()
            ->findOrFail($id);

        $paramWorkout = $routine->parameterizedWorkouts()->findOrFail($request->input('paramWorkout'));

        //TODO validate input values
        //TODO modify and save in a single transaction
        $paramWorkout->sets = $request->input('sets');

        if($request->has('repetitions')){
            $paramWorkout->repetitions = $request->input('repetitions');
        }else if($request->has('holding_period')){
            $paramWorkout->holding_period = $request->input('holding_period');
        }

        $paramWorkout->rest = $request->input('rest');

        //TODO: check if weight should be editable on assignment
        //$paramWorkout->weight = $request->input('weight');

        $paramWorkout->save();

        return redirect()->action('App\Http\Controllers\RoutinesController@workouts', [ $routine->id ]);
    }
   
}
