<?php

namespace App\Http\Controllers;

use App\Models\ParameterizedWorkout;
use App\Models\Workout;
use Illuminate\Http\Request;
use Session;

//DEPRECATED
class RoutineWorkoutsController extends Controller
{
    public function __construct()
    {
        $this->middleware('routine.accessible');
    }

    /**
     * Display a listing of the resource.
     *
     * @param $routineId
     * @return Response
     */
    public function index($routineId)
    {

        $workouts = Workout::visible()->withTranslation()->get();
        $paramWorkouts = ParameterizedWorkout::whereWorkoutRoutineId($routineId)
            ->withTranslation()
            ->get();

        return view('routines.workout-overview', compact('routineId', 'workouts', 'paramWorkouts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $routineId
     * @return Response
     */
    public function create($routineId)
    {
        $workouts = Workout::visible()
            ->withTranslation()
            ->get();

        return view('routines.workouts.create', compact('routineId', 'workouts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, $routineId)
    {
        $this->validate($request, [
            'workout_id' => 'required'
        ]);

        $workout = Workout::visible()
            ->findOrFail($request->input('workout_id'));

        $this->validate($request, $this->validationRules($workout));

        $paramWorkout = new ParameterizedWorkout($request->input());
        $paramWorkout->workout_routine_id = $routineId;
        $paramWorkout->workout()->associate($workout);
        $paramWorkout->save();

        return redirect()->action('App\Http\Controllers\RoutineWorkoutsController@show', [$routineId, $paramWorkout->id]);
    }

    /**
     * @param $routineId
     * @param $workoutId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($routineId, $workoutId)
    {
        $paramWorkout = ParameterizedWorkout::whereWorkoutRoutineId($routineId)
            ->withTranslation()
            ->findOrFail($workoutId);

        $translation = $paramWorkout->translations->first();

        return view('routines.workouts.show', compact('paramWorkout', 'translation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $routineId
     * @param $workoutId
     * @return \Illuminate\View\View
     */
    public function edit($routineId, $workoutId)
    {
        $paramWorkout = ParameterizedWorkout::withTranslation()
            ->whereWorkoutRoutineId($routineId)
            ->findOrFail($workoutId);

        $this->flash($paramWorkout);

        return view('routines.workouts.edit', compact('routineId', 'paramWorkout'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $routineId
     * @param $workoutId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $routineId, $workoutId)
    {
        $paramWorkout = ParameterizedWorkout::whereWorkoutRoutineId($routineId)
            ->findOrFail($workoutId);

        $this->validate($request, $this->validationRules($paramWorkout->workout));

        $paramWorkout->update($request->input());

        return redirect()->action('App\Http\Controllers\RoutineWorkoutsController@show', [$routineId, $workoutId]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $routineId
     * @param $workoutId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($routineId, $workoutId)
    {
        ParameterizedWorkout::whereWorkoutRoutineId($routineId)
            ->findOrFail($workoutId)
            ->delete();

        return redirect()->action('App\Http\Controllers\RoutineWorkoutsController@index', [$routineId]);
    }

    private function flash(ParameterizedWorkout $paramWorkout) {
        Session::flashInput([
            'holding_period' => old('holding_period', $paramWorkout->holding_period),
            'repetitions' => old('repetitions', $paramWorkout->repetitions),
            'sets' => old('sets',  $paramWorkout->sets),
            'rest' => old('rest', $paramWorkout->rest),
            'weight' => old('weight', $paramWorkout->weight),
        ]);
    }

    private function validationRules(Workout $workout) {
        $rules = [
            'sets' => 'required|integer',
            'rest' => 'required|string',
        ];

        if ($workout->type === 1) {
            $rules['repetitions'] = 'required|integer';
        } else {
            $rules['holding_period'] = 'required|string';
        }

        if ($workout->equipment_needed) {
            $rules['weight'] = 'required|string';
        }

        return $rules;
    }
}
