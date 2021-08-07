@extends('layouts.main')

@section('title', 'Routine Workouts')

@section('content')
    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--12-col">
            <h1>Übungen des Übungsplans</h1>
            <p>
                <a href="{{ action('App\Http\Controllers\RoutineWorkoutsController@create', [ $routineId ]) }}">
                    <i class="fa fa-plus-circle"></i> {{ trans('messages.routines.workouts.create.link') }}
                </a>
            </p>
            <hr/>
            @foreach($paramWorkouts as $paramWorkout)
                <div>
                    <p>
                        <a href="{{ action('App\Http\Controllers\RoutineWorkoutsController@show', [ $routineId, $paramWorkout->id ]) }}">
                            {{ $paramWorkout->translations->first()->title }}
                        </a>
                    </p>
                </div>
            @endforeach
        </div>
    </div>
@endsection
