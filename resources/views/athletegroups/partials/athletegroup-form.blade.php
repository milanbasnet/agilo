<div class="ag-card-nav uk-margin-bottom">
    <a href="{{ action('App\Http\Controllers\AthletesGroupsOverviewController@index') }}" class="ag-icon-fab" title="Zurück">
        <i class="material-icons">close</i>
    </a>

    <button type="submit" class="ag-icon-fab uk-float-right" title="Speichern">
        <i class="material-icons">check</i>
    </button>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="title">Name</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="title" name="title" value="{{ old('title') }}">
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="description">Beschreibung</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="description" name="description" value="{{ old('description') }}">
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="sport">Sportart</label>
    <div class="uk-form-controls">
        <select class="uk-select" id="sport" name="sport">
            <option value="" disabled {{ old('sport') ? '' : 'selected' }}>Sportart auswählen</option>
            @foreach(\App\Models\AthleteGroupSport::all() as $sport)
                <option value="{{ $sport->id }}"
                        {{ $sport->selected(old('sport')) ? 'selected' : '' }}>
                    {{ trans($sport->i18n) }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="level">Niveau</label>
    <div class="uk-form-controls">
        <select class="uk-select" id="level" name="level">
            <option value="" disabled {{ old('level') ? '' : 'selected' }}>Niveau auswählen</option>
            @foreach(\App\Models\AthleteGroupLevel::all() as $level)
                <option value="{{ $level->id }}"
                        {{ $level->id == old('level') ? 'selected' : '' }}>
                    {{ trans($level->i18n) }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="workouts_per_week">Trainingseinheiten/Woche</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="workouts_per_week" name="workouts_per_week" type="number" min="1" max="14" value="{{ old('workouts_per_week') }}">
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="users">Betreuer</label>
    <div class="uk-form-controls">
        <select class="uk-select" id="users" name="users[]" multiple size="5">
            @foreach(\App\Models\Office::therapists() as $user)
                <option value="{{ $user->id }}"
                        {{ collect(old('users'))->contains($user->id) ? 'selected' : '' }}>
                    {{ $user->last_name . ', ' . $user->first_name }}
                </option>
            @endforeach
        </select>
    </div>
</div>