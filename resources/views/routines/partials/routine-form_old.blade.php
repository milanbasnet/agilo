@include('routines.partials.translation-input')

<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <label class="mdl-textfield__label">Ersteller</label>
    <label class="mdl-textfield__label">{{ old('creator') }}</label>
</div>
<div>
    <label for="frequence_default">Frequenz:
        <select id="frequence_default" name="frequence_default">
            @for( $i= 1; $i <= 7; $i++)
            <option value="{{$i}}"
                @if($i == old('frequence_default'))
                    selected
                @endif
            >{{$i}}x pro Woche</option>
            @endfor
        </select>
    </label>
</div>
<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <label class="mdl-textfield__label" for="duration_default">Dauer:</label>
    <input id="duration_default" class="mdl-textfield__input" type="number" min="0" max="24" name="duration_default" value="{{ old('duration_default') }}">
    <label class="mdl-textfield__label">Wochen</label>
</div>

<hr />
<h4>Sportarten</h4>
<div class="mdl-grid">
    @foreach($sports as $sport)
    <div class="mdl-cell mdl-cell--4-col">
        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-{{$sport->id}}">
            <input type="checkbox" id="checkbox-{{$sport->id}}" value="{{$sport->id}}" name="sport_tag_ids[]" class="mdl-checkbox__input"
            @if(!isset($relatedSportTagIds) || in_array($sport->id,$relatedSportTagIds->toArray()))
                checked
            @endif
            >
            <span class="mdl-checkbox__label">{{$sport->name}}</span>
        </label>
    </div>
    @endforeach
</div>
<hr />
<div>
    <label for="measure_tag">Maßnahme:
        <select id="measure_tag" name="measure_tag_id">
            @foreach($measures as $measure)
                <option value="{{$measure->id}}"
                @if($measure->id == old('measure_tag_id'))
                    selected
                @endif
                >{{$measure->name}}</option>
            @endforeach
        </select>
    </label>
</div>
<div>
    <label for="gender_tag">Speziell für:
        <select id="gender_tag" name="gender_tag_id">
            @foreach($genders as $gender)
                <option value="{{$gender->id}}"
                @if($gender->id == old('gender_tag_id'))
                    selected
                @endif
                >{{$gender->name}}</option>
            @endforeach
        </select>
    </label>
</div>
<hr />
<div>
    <label for="age_tag">Alter:
        <select id="age_tag" name="age_tag_id">
            @foreach($ages as $age)
                <option value="{{$age->id}}"
                @if($age->id == old('age_tag_id'))
                    selected
                @endif
                >{{$age->name}}</option>
            @endforeach
        </select>
    </label>

<hr />
<h4>Trainierte Region</h4>
<div class="mdl-grid">
    @foreach($regions as $region)
        <div class="mdl-cell mdl-cell--4-col">
            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="cb_region-{{$region->id}}">
                <input type="checkbox" id="cb_region-{{$region->id}}" value="{{$region->id}}" name="region_tag_ids[]" class="mdl-checkbox__input"
                   @if(!isset($relatedRegionTagIds) || in_array($region->id,$relatedRegionTagIds->toArray()))
                    checked
                   @endif
                >
                <span class="mdl-checkbox__label">{{$region->name}}</span>
            </label>
        </div>
    @endforeach
</div>
<hr />
<h4>Trainingsziel</h4>
<div class="mdl-grid">
    @foreach($objectives as $objective)
        <div class="mdl-cell mdl-cell--4-col">
            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="cb_objective-{{$objective->id}}">
                <input type="checkbox" id="cb_objective-{{$objective->id}}" value="{{$objective->id}}" name="objective_tag_ids[]" class="mdl-checkbox__input"
                   @if(!isset($relatedObjectiveTagIds) || in_array($objective->id,$relatedObjectiveTagIds->toArray()))
                    checked
                   @endif
                >
                <span class="mdl-checkbox__label">{{$objective->name}}</span>
            </label>
        </div>
    @endforeach
</div>
<div class="uk-margin-bottom">
    <label class="uk-form-label" for="level">Level</label>
    <div class="uk-form-controls">
        <select class="uk-select" id="level" name="level_tag_id">
            @foreach(\App\Models\LevelTag::all() as $level)
                <option value="{{$level->id}}"
                        @if($level->id === old('level_tag_id'))
                        selected
                        @endif
                >{{$level->name}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <label class="mdl-textfield__label" for="pubmedlink">PubMedLink</label>
    <input id="pubmedlink" class="mdl-textfield__input" type="text" name="pubmed_link" value="{{ old('pubmed_link') }}">
</div>


@include('routines.partials.submit-input')