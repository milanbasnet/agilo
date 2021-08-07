@extends('layouts.main')

@section('title', 'Edit Parameterized Workout')

@section('content')
    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--12-col">
            <h1>{{ trans('messages.routines.workouts.edit.header') }}</h1>
            <hr/>
        </div>
        <div class="mdl-cell mdl-cell--3-col">
            <form method="POST" action="{{ action('App\Http\Controllers\RoutineWorkoutsController@update', [ $routineId, $paramWorkout->id ]) }}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="PATCH" />

                <h3>{{ $paramWorkout->workout->translations->first()->title }}</h3>

                @if($paramWorkout->workout->type === 1)
                    @if($paramWorkout->workout->repetitions_split)
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input id="repetitions_split_a" class="mdl-textfield__input" type="text" name="repetitions_split_a" value="{{ old('repetitions_split_a') }}">
                            <label class="mdl-textfield__label" for="repetitions_split_a">{{ trans('messages.repetitions_split_a.label') }}</label>
                        </div>

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input id="repetitions_split_b" class="mdl-textfield__input" type="text" name="repetitions_split_b" value="{{ old('repetitions_split_b') }}">
                            <label class="mdl-textfield__label" for="repetitions_split_b">{{ trans('messages.repetitions_split_b.label') }}</label>
                        </div>
                    @else
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input id="repetitions" class="mdl-textfield__input" type="text" name="repetitions" value="{{ old('repetitions') }}">
                            <label class="mdl-textfield__label" for="repetitions">{{ trans('messages.repetitions.label') }}</label>
                        </div>
                    @endif
                @elseif($paramWorkout->workout->type === 2)
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input id="holding_period" class="mdl-textfield__input" type="text" name="holding_period" value="{{ old('holding_period') }}">
                        <label class="mdl-textfield__label" for="holding_period">{{ trans('messages.holding_period.label') }}</label>
                    </div>
                @endif

                @if($paramWorkout->workout->equipment_needed)
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input id="weight" class="mdl-textfield__input" type="text" name="weight" value="{{ old('weight') }}">
                        <label class="mdl-textfield__label" for="weight">{{ trans('messages.weight.label') }}</label>
                    </div>
                @endif

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input id="sets" class="mdl-textfield__input" type="text" name="sets" value="{{ old('sets') }}">
                    <label class="mdl-textfield__label" for="sets">{{ trans('messages.sets.label') }}</label>
                </div>

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input id="rest" class="mdl-textfield__input" type="text" name="rest" value="{{ old('rest') }}">
                    <label class="mdl-textfield__label" for="rest">{{ trans('messages.rest.label') }}</label>
                </div>

                @include('routines.partials.submit-input', [ 'submitMessageKey' => 'messages.routines.workouts.edit.submit.label' ])
            </form>
        </div>
    </div>
@endsection
