@extends('layouts.main')

@section('title', $translation->title)

@section('content')
    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--12-col">
            <div class="mdl-card mdl-shadow--4dp">
                <div class="mdl-card__media">
                    <img src="{{ asset('/storage/'.$paramWorkout->workout->image_path) }}" alt="Workout Bild"/>
                </div>
                <div class="mdl-card__title">
                    <h2 class="mdl-card__title-text">{{ $translation->title }}</h2>
                </div>
                <div class="mdl-card__supporting-text">
                    {{ $translation->description }}
                </div>
                <div class="mdl-card__supporting-text">
                    @if($paramWorkout->workout->type === 1)
                        <p>Wiederholungen: {{ $paramWorkout->repetitions }}</p>
                    @elseif($paramWorkout->workout->type === 2)
                        <p>Haltedauer: {{ $paramWorkout->holding_period }}</p>
                    @endif

                    @if($paramWorkout->workout->equipment_needed)
                        <p>Gewicht: {{ $paramWorkout->weight }}</p>
                    @endif

                    <p>Sätze: {{ $paramWorkout->sets }}</p>

                    <p>Pause: {{ $paramWorkout->rest }}</p>
                </div>
                <div class="mdl-card__actions">
                    <a href="{{ action('App\Http\Controllers\RoutineWorkoutsController@edit', [ $paramWorkout->workout_routine_id, $paramWorkout->id ]) }}" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
                        <i class="material-icons">create</i>
                    </a>
                </div>
            </div>

            <p><br><a href="{{ action('App\Http\Controllers\RoutineWorkoutsController@create', [$paramWorkout->workout_routine_id]) }}">Weitere Übung zuweisen</a></p>
            <p><a href="{{ action('App\Http\Controllers\RoutinesController@show', [$paramWorkout->workout_routine_id]) }}">Zum Übungsplan</a></p>
            <p><a href="{{ action('App\Http\Controllers\RoutineWorkoutsController@index', [$paramWorkout->workout_routine_id]) }}">Zu den Übungen des Übungsplans</a></p>

            <form method="POST" action="{{ action('App\Http\Controllers\RoutineWorkoutsController@destroy', [ $paramWorkout->workout_routine_id, $paramWorkout->id ]) }}">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="DELETE" />

                <button type="submit" class="mdl-button mdl-js-button mdl-js-ripple-effect">
                    {{ trans('messages.routines.workouts.delete.submit.label') }}
                </button>
            </form>
        </div>
    </div>
@endsection