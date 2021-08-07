<div class="uk-margin-bottom">
    <label class="uk-form-label" for="title">{{ trans('messages.routines.title.label') }}</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="title" name="translation[de][title]" value="{{ old('translation.de.title') }}">
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
    <label class="uk-form-label" for="measure">Maßnahme</label>
    <div class="uk-form-controls">
        <select class="uk-select" id="measure" name="measure">
            <option value="" disabled {{ old('measure') ? '' : 'selected' }}>Maßnahme auswählen</option>
            @foreach(\App\Models\MeasureTag::all() as $measure)
                <option value="{{ $measure->id }}"
                        {{ $measure->id == old('measure') ? 'selected' : '' }}>
                    {{ $measure->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="regions">Trainierte Region</label>
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
    <label class="uk-form-label" for="injuries">{{ trans('messages.routines.injuries.label') }}</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="injuries" name="translation[de][injuries]" value="{{ old('translation.de.injuries') }}">
    </div>
</div>

<div uk-grid='{"margin": ""}'>
    <div class="uk-width-1-2">
        <div class="uk-margin-bottom">
            <label class="uk-form-label" for="objective">Trainingsziel</label>
            <div class="uk-form-controls">
                <select class="uk-select" id="objective" name="objective">
                    <option value="" disabled {{ old('objective') ? '' : 'selected' }}>Trainingsziel auswählen</option>
                    @foreach(\App\Models\ObjectiveTag::all() as $objective)
                        <option value="{{ $objective->id }}"
                                {{ $objective->id == old('objective') ? 'selected' : '' }}>
                            {{ $objective->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="uk-width-1-2">
        <div class="uk-margin-bottom">
            <label class="uk-form-label" for="level">Level</label>
            <div class="uk-form-controls">
                <select class="uk-select" id="level" name="level">
                    <option value="" disabled {{ old('level') ? '' : 'selected' }}>Level auswählen</option>
                    @foreach(\App\Models\LevelTag::all() as $level)
                        <option value="{{ $level->id }}"
                                {{ $level->id == old('level') ? 'selected' : '' }}>
                            {{ $level->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="uk-width-1-2">
        <div class="uk-margin-bottom">
            <label class="uk-form-label" for="gender">Geschlecht</label>
            <div class="uk-form-controls">
                <select class="uk-select" id="gender" name="gender">
                    <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Geschlecht auswählen</option>
                    @foreach(\App\Models\GenderTag::all() as $gender)
                        <option value="{{ $gender->id }}"
                                {{ $gender->id == old('gender') ? 'selected' : '' }}>
                            {{ $gender->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="uk-width-1-2">
        <div class="uk-margin-bottom">
            <label class="uk-form-label" for="age">Alter</label>
            <div class="uk-form-controls">
                <select class="uk-select" id="age" name="age">
                    <option value="" disabled {{ old('age') ? '' : 'selected' }}>Alter auswählen</option>
                    @foreach(\App\Models\AgeTag::all() as $age)
                        <option value="{{ $age->id }}"
                                {{ $age->id == old('age') ? 'selected' : '' }}>
                            {{ $age->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="uk-width-1-2">
        <div class="uk-margin-bottom">
            <label class="uk-form-label" for="frequence_default">Frequenz</label>
            <div class="uk-form-controls">
                <select class="uk-select" id="frequence_default" name="frequence_default">
                    <option value="" disabled {{ old('frequence_default') ? '' : 'selected' }}>Frequenz auswählen</option>
                    @for($i = \App\Models\Frequency::MIN; $i <= \App\Models\Frequency::MAX; $i++)
                        <option value="{{ $i }}"
                                {{ $i == old('frequence_default') ? 'selected' : '' }}>
                            {{ \App\Models\Frequency::label($i) }}
                        </option>
                    @endfor
                </select>
            </div>
        </div>
    </div>
    <div class="uk-width-1-2">
        <div class="uk-margin-bottom">
            <label class="uk-form-label" for="duration_default">Dauer</label>
            <div class="uk-form-controls">
                <input class="uk-input" id="duration_default" name="duration_default" type="number" min="0" max="24" value="{{ old('duration_default', 1) }}">
            </div>
        </div>
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="pubmed_link">Link zu PubMed</label>
    <div class="uk-form-controls">
        <input class="uk-input" type="url" id="pubmed_link" name="pubmed_link" value="{{ old('pubmed_link') }}">
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="description">{{ trans('messages.routines.description.label') }}</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="description" name="translation[de][description]" value="{{ old('translation.de.description') }}">
    </div>
</div>