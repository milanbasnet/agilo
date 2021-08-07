@extends('layouts.main')

@section('title', 'Add Workout')

@section('content')
    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--12-col">
            <h1>{{ trans('messages.routines.workouts.create.header') }}</h1>
            <hr/>
        </div>
        <div class="mdl-cell mdl-cell--3-col">
            <form method="POST" action="{{ action('App\Http\Controllers\RoutineWorkoutsController@store', [$routineId]) }}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="mdl-selectfield">
                    <select name="workout_id" id="workout-select">
                        <option value="" disabled {{ old('workout_id') ? '' : 'selected' }}>Übung auswählen</option>
                        @foreach($workouts as $workout)
                            <option value="{{ $workout->id }}"
                                    data-workout-model="{{ $workout->toJson() }}"
                                    {{ $workout->id == old('workout_id') ? 'selected' : '' }}>
                                {{ $workout->translations->first()->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input id="repetitions" class="mdl-textfield__input" type="text" name="repetitions" value="{{ old('repetitions') }}">
                    <label class="mdl-textfield__label" for="repetitions">{{ trans('messages.repetitions.label') }}</label>
                </div>

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input id="holding_period" class="mdl-textfield__input" type="text" name="holding_period" value="{{ old('holding_period') }}">
                    <label class="mdl-textfield__label" for="holding_period">{{ trans('messages.holding_period.label') }}</label>
                </div>

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input id="weight" class="mdl-textfield__input" type="text" name="weight" value="{{ old('weight') }}">
                    <label class="mdl-textfield__label" for="weight">{{ trans('messages.weight.label') }}</label>
                </div>

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input id="sets" class="mdl-textfield__input" type="text" name="sets" value="{{ old('sets') }}">
                    <label class="mdl-textfield__label" for="sets">{{ trans('messages.sets.label') }}</label>
                </div>

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input id="rest" class="mdl-textfield__input" type="text" name="rest" value="{{ old('rest') }}">
                    <label class="mdl-textfield__label" for="rest">{{ trans('messages.rest.label') }}</label>
                </div>

                <p>@include('routines.partials.submit-input', [ 'submitMessageKey' => 'messages.routines.workouts.create.submit.label' ])</p>
            </form>
        </div>
    </div>

    <div id="workouts-model" data-workouts-model="{{ $workouts->toJson() }}"></div>

@endsection

@section('scripts')
    <script>

        var prefillFieldsWithDefaults = function(workout){
            $('#sets').val(workout.sets_default);
            $('#rest').val(workout.rest_default);

            var $field_holding_period = $('#holding_period');
            if($field_holding_period.is(":visible")){
                $field_holding_period.val(workout.holding_period_default);
            }else{
                $field_holding_period.val("");
            }

            var $field_repetitions = $('#repetitions');
            if($field_repetitions.is(":visible")){
                $field_repetitions.val(workout.repetitions_default);
            }else{
                $field_repetitions.val("");
            }

            var $field_weight = $('#weight');
            if($field_weight.is(":visible")){
                $field_weight.val(workout.weight_default);
            }else{
                $field_weight.val("");
            }
        };

        $(function(){
            $('.mdl-textfield').hide();
            $('#rest, #sets').parent('.mdl-textfield').show();
            $workoutSelect = $('#workout-select');

            $workoutSelect.on('change', function() {
                var workout = $('option:selected').data('workout-model');

                if (workout.type === 1) {
                    $('#holding_period').parent('.mdl-textfield').hide();
                    $('#repetitions').parent('.mdl-textfield').show();
                } else if (workout.type === 2) {
                    $('#holding_period').parent('.mdl-textfield').show();
                    $('#repetitions').parent('.mdl-textfield').hide();
                }


                if (workout.equipment_needed) {
                    $('#weight').parent('.mdl-textfield').show();
                } else {
                    $('#weight').parent('.mdl-textfield').hide();
                }

                //fill default_values
                prefillFieldsWithDefaults(workout);


            });

            if ($workoutSelect.val() !== null) {
                $workoutSelect.trigger('change');
            }
        });
    </script>
@endsection