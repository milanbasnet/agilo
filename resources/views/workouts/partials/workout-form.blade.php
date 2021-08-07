<div class="uk-margin-bottom">
    <label class="uk-form-label" for="title">Name der Übung - Backend</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="title" name="translation[de][title]" value="{{ old('translation.de.title') }}">
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="titleInApp">Name der Übung - App</label>
    <div class="uk-form-controls">
{{-- TODO: validation error indicator:
       <input class="uk-input{{ $errors->has('translation.de.title_in_app') ? ' uk-form-danger': ''}}" id="titleInApp" name="translation[de][title_in_app]" value="{{ old('translation.de.title_in_app') }}">--}}
        <input class="uk-input" id="titleInApp" name="translation[de][title_in_app]" value="{{ old('translation.de.title_in_app') }}">
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="video">{{ trans('messages.video.label') }}</label>
    <div class="uk-child-width-1-2" uk-grid>
        <div class="ag-js-file-preview uk-text-break">
            @if(old('video_path'))
                <video class="ag-image-border" src="{{ asset('/storage/'.old('video_path')) }}" controls></video>
            @endif
        </div>
        <div class="ag-js-file-input">
            <div class="js-upload uk-float-right" uk-form-custom>
                <input type="file" name="video" id="video">
                <button class="uk-button uk-button-default ag-special-button" type="button" tabindex="-1">
                    <span>Upload</span>
                    <i class="material-icons">file_upload</i>
                </button>
            </div>
        </div>
    </div>
</div>



<div class="uk-margin-bottom">
    <label class="uk-form-label" for="image">{{ trans('messages.image.label') }}</label>
    <div class="uk-child-width-1-2" uk-grid>
        <div class="ag-js-file-preview uk-text-break">
            @if(old('image_path'))
                <img class="ag-image-border" src="{{ asset('/storage/'.old('image_path')) }}" />
            @endif
        </div>
        <div class="ag-js-file-input">
            <div class="js-upload uk-float-right" uk-form-custom>
                <input type="file" name="image" id="image">
                <button class="uk-button uk-button-default ag-special-button" type="button" tabindex="-1">
                    <span>Upload</span>
                    <i class="material-icons">file_upload</i>
                </button>
            </div>
        </div>
    </div>
</div>

<hr class="ag-divider">
<p class="ag-divider-label">Standardeinstellungen</p>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="type">Typ der Übung</label>
    <div class="uk-form-controls">
        <select class="uk-select" id="type" name="type">
            <option value="" disabled {{ old('type') ? '' : 'selected' }}>Typ der Übung auswählen</option>
            @foreach(\App\Models\WorkoutType::values() as $type)
                <option value="{{ $type->value }}"
                        {{ $type->value == old('type') ? 'selected' : '' }}>
                    {{ trans('messages.' . $type->label) }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="sets_default">Sätze</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="sets_default" name="sets_default" type="number" min="1" max="50" value="{{ old('sets_default', 1) }}">
    </div>
</div>

<div class="uk-margin-bottom ag-js-repitions-wrapper">
    <label class="uk-form-label" for="repetitions_default">Wiederholungen</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="repetitions_default" name="repetitions_default" type="number" min="1" max="50" value="{{ old('repetitions_default', 1) }}">
    </div>
</div>

<div class="uk-margin-bottom ag-js-holding-period-wrapper">
    <label class="uk-form-label" for="holding_period_default">Haltezeit in Sekunden</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="holding_period_default" name="holding_period_default" type="number" min="0" max="300" value="{{ old('holding_period_default', 0) }}">
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="rest_default">Pause in Sekunden</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="rest_default" name="rest_default" type="number" min="0" max="600" value="{{ old('rest_default', 0) }}">
    </div>
</div>

<div class="uk-margin">
    <div class="uk-form-controls ag-font-size-form-input">
        <label for="equipment_needed"><input class="uk-checkbox" type="checkbox" id="equipment_needed" name="equipment_needed" {!! old('equipment_needed') ? 'checked=checked' : '' !!} value="1"> {{ trans('messages.workouts.create.equipment.label') }}</label>
    </div>
</div>

<div class="uk-margin-bottom ag-js-material-wrapper">
    <label class="uk-form-label" for="equipment">Material</label>
    <div class="uk-form-controls">
        <select class="uk-select" id="equipment" name="equipment_id">
            <option value="" disabled {{ old('equipment_id') ? '' : 'selected' }}>Material auswählen</option>
            @foreach(\App\Models\Equipment::all() as $equipment)
                <option value="{{ $equipment->id }}"
                        {{ $equipment->id == old('equipment_id') ? 'selected' : '' }}>
                    {{ $equipment->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="uk-margin-bottom ag-js-material-weight-wrapper">
    <label class="uk-form-label" for="weight_default">Gewicht des Materials [kg]</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="weight_default" name="weight_default" type="number" min="0" max="600" value="{{ old('weight_default') }}">
    </div>
</div>

<hr class="ag-divider">
<p class="ag-divider-label">Beschreibung</p>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="starting_position">{{ trans('messages.starting_position.label') }}</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="starting_position" name="translation[de][starting_position]" value="{{ old('translation.de.starting_position') }}">
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="execution">{{ trans('messages.execution.label') }}</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="execution" name="translation[de][execution]" value="{{ old('translation.de.execution') }}">
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="pace_tag">Tempo</label>
    <div class="uk-form-controls">
        <select class="uk-select" id="pace_tag" name="pace_tag_id">
            <option value="" disabled {{ old('pace_tag_id') ? '' : 'selected' }}>Tempo auswählen</option>
            @foreach(\App\Models\PaceTag::all() as $pace_tag)
                <option value="{{ $pace_tag->id }}"
                        {{ $pace_tag->id == old('pace_tag_id') ? 'selected' : '' }}>
                    {{ $pace_tag->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="hints">{{ trans('messages.hints.label') }}</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="hints" name="translation[de][hints]" value="{{ old('translation.de.hints') }}">
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="difficulty">{{ trans('messages.difficulty.label') }}</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="difficulty" name="translation[de][difficulty]" value="{{ old('translation.de.difficulty') }}">
    </div>
</div>

<hr class="ag-divider">
<p class="ag-divider-label">Tags</p>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="regions">Region</label>
    <div class="uk-form-controls">
        <select class="uk-select" id="regions" name="regions[]" size="5" multiple>
            @foreach(\App\Models\RegionTag::all() as $region)
                <option value="{{ $region->id }}"
                        {{ collect(old('regions'))->contains($region->id) ? 'selected' : '' }}>
                    {{ $region->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="types">Art</label>
    <div class="uk-form-controls">
        <select class="uk-select" id="types" name="types[]" size="5" multiple>
            @foreach(\App\Models\TypeTag::all() as $type)
                <option value="{{ $type->id }}"
                        {{ collect(old('types'))->contains($type->id) ? 'selected' : '' }}>
                    {{ $type->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="level">Level</label>
    <div class="uk-form-controls">
        <select class="uk-select" id="level" name="level_tag_id">
            <option value="" disabled {{ old('level_tag_id') ? '' : 'selected' }}>Level auswählen</option>
            @foreach(\App\Models\LevelTag::all() as $level)
                <option value="{{ $level->id }}"
                        {{ $level->id == old('level_tag_id') ? 'selected' : '' }}>
                    {{ $level->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

@section('scripts')
    <script type="text/javascript">
        $(function() {


            //show/hide inputs regarding to the selected workout type

            var $typeSelect = $('#type'),
                $repetitionsInput = $('.ag-js-repitions-wrapper'),
                $holdingPeriodInput = $('.ag-js-holding-period-wrapper');

            $typeSelect.change(function ($element) {
                if ($typeSelect.val() == 2) {
                    $repetitionsInput.find('#repetitions_default').prop("disabled", true);
                    $repetitionsInput.hide();

                    $holdingPeriodInput.find('#holding_period_default').prop("disabled", false);
                    $holdingPeriodInput.show();
                } else {
                    $repetitionsInput.find('#repetitions_default').prop("disabled", false);
                    $repetitionsInput.show();

                    $holdingPeriodInput.find('#holding_period_default').prop("disabled", true);
                    $holdingPeriodInput.hide();
                }
            });

            var $equipmentNeededCheckbox = $('#equipment_needed'),
                $materialWrapper = $('.ag-js-material-wrapper'),
                $materialWeightWrapper = $('.ag-js-material-weight-wrapper');

            $equipmentNeededCheckbox.change(function ($element) {
                if ($equipmentNeededCheckbox.is(':checked')) {
                    $materialWrapper.find('#equipment').prop("disabled", false);
                    $materialWrapper.show();

                    $materialWeightWrapper.find('#weight_default').prop("disabled", false);
                    $materialWeightWrapper.show();
                } else {
                    $materialWrapper.find('#equipment').prop("disabled", true);
                    $materialWrapper.hide();

                    $materialWeightWrapper.find('#weight_default').prop("disabled", true);
                    $materialWeightWrapper.hide();
                }
            });

            $typeSelect.trigger('change');
            $equipmentNeededCheckbox.trigger('change');
        });
    </script>
@endsection