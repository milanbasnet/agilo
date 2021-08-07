<div class="ag-card-nav uk-margin-bottom">
    <a href="{{ action('App\Http\Controllers\AthletesGroupsOverviewController@index') }}" class="ag-icon-fab" title="Zurück">
        <i class="material-icons">close</i>
    </a>

    <button type="submit" class="ag-icon-fab uk-float-right" title="Speichern">
        <i class="material-icons">check</i>
    </button>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="first_name">Vorname</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="first_name" name="first_name" value="{{ old('first_name') }}">
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="last_name">Nachname</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="last_name" name="last_name" value="{{ old('last_name') }}">
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="birth">Geburtstag</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="birth" name="birth" type="date" data-ag-max-date="{{ $maxDate }}" data-ag-min-date="{{ $minDate }}" value="{{ old('birth') }}">
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="email">Email</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="email" name="email" type="email" value="{{ old('email') }}">
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="sex">Geschlecht</label>
    <div class="uk-form-controls">
        <select class="uk-select" id="sex" name="sex">
            <option value="" disabled {{ old('sex') ? '' : 'selected' }}>Geschlecht auswählen</option>
            @foreach(\App\Models\Sex::values() as $value)
                <option value="{{ $value->value }}"
                        {{ $value->value == old('sex') ? 'selected' : '' }}>
                    {{ trans('messages.' . $value->label) }}
                </option>
            @endforeach
        </select>
    </div>
</div>