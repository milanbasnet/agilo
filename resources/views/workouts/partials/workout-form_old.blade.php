<div class="ag-card-nav uk-margin-bottom">
    <a href="{{ action('App\Http\Controllers\AthletesGroupsOverviewController@index') }}" class="ag-icon-fab" title="Zurück">
        <i class="material-icons">close</i>
    </a>
    @include('workouts.partials.submit-input')
</div>

@include('workouts.partials.translation-input')

@include('workouts.partials.file-input', [ 'label' => 'messages.image.label', 'name' => 'image'])

@include('workouts.partials.file-input', [ 'label' => 'messages.video.label', 'name' => 'video'])

<hr class="ag-divider">
<p class="ag-divider-label">Standardeinstellungen</p>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="type">Übungstyp</label>
    <div class="uk-form-controls">
        <select class="uk-select" id="type" name="type">
            <option value="1"
            @if( 1 == old('type'))
                selected
            @endif
            >Dynamisch</option>
            <option value="2"
            @if( 2 == old('type'))
                selected
            @endif
            >Statisch</option>
        </select>
    </div>
</div>
<div class="uk-margin-bottom">
    <label class="uk-form-label" for="sets_default">Sätze</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="sets_default" type="number" min="1" max="50" name="sets_default" value="{{ old('sets_default') }}">
    </div>
</div>

<div class="uk-margin-bottom" id="repetitions_wrapper">
    <label class="uk-form-label" for="repetitions_default">Wiederholungen</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="repetitions_default" type="number" min="1" max="50" name="repetitions_default" value="{{ old('repetitions_default') }}">
    </div>
</div>

<div class="uk-margin-bottom" id="holding_period_wrapper">
    <label class="uk-form-label" for="holding_period_default">Haltezeit (Sek.)</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="holding_period_default" type="number" min="1" max="300" name="holding_period_default" value="{{ old('holding_period_default') }}">
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="rest_default">Satzpausen (Sek.)</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="rest_default" type="number" min="1" max="300" name="rest_default" value="{{ old('rest_default') }}">
    </div>
</div>

<hr class="ag-divider">
<p class="ag-divider-label">Beschreibung</p>
@include('workouts.partials.translation-description-input')

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="pace_tag">Tempo</label>
    <div class="uk-form-controls">
        <select class="uk-select" id="pace_tag" name="pace_tag_id">
            {{--*/ $paceTagSelectedId = old('pace_tag_id') != null ? old('pace_tag_id') : 2 /*--}}
            @foreach(\App\Models\PaceTag::all() as $pace_tag)
                <option value="{{$pace_tag->id}}"
                        @if( $paceTagSelectedId === $pace_tag->id)
                        selected
                        @endif
                >{{$pace_tag->name}}</option>
            @endforeach
        </select>
    </div>
</div>

<hr class="ag-divider">
<p class="ag-divider-label">Tags</p>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="region_tags">Region</label>
    <div class="uk-form-controls">
        <select class="uk-select" id="region_tags" name="region_tag_ids[]" size="5" multiple>
            @foreach(\App\Models\RegionTag::all() as $region_tag)
                <option value="{{$region_tag->id}}"
                        @if(isset($relatedRegionTagIds) && in_array($region_tag->id,$relatedRegionTagIds->toArray()))
                        selected
                        @endif
                >{{$region_tag->name}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="type_tags">Art</label>
    <div class="uk-form-controls">
        <select class="uk-select" id="type_tags" name="type_tag_ids[]" size="5" multiple>
            @foreach(\App\Models\TypeTag::all() as $type_tag)
                <option value="{{$type_tag->id}}"
                        @if(isset($relatedTypeTagIds) && in_array($type_tag->id,$relatedTypeTagIds->toArray()))
                        selected
                        @endif
                >{{$type_tag->name}}</option>
            @endforeach
        </select>
    </div>
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

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="equipment">Material</label>
    <div class="uk-form-controls">
        <select class="uk-select" id="equipment" name="equipment_id">
            <option value="">--Ohne Material--</option>
            @foreach(\App\Models\Equipment::all() as $equipment)
                <option value="{{$equipment->id}}"
                        @if($equipment->id === old('equipment_id'))
                        selected
                        @endif
                >{{$equipment->name}}</option>
            @endforeach
        </select>
    </div>
</div>

@section('scripts')
<script type="text/javascript">

    //show/hide inputs regarding to the selected workout type

    var $typeSelect = $('#type');
    $typeSelect.change(function ($element) {

        $repetitionsInput = $('#repetitions_wrapper');
        $holdingPeriodInput = $('#holding_period_wrapper');
        if($typeSelect.val() == 2){
            $repetitionsInput.find('#repetitions_default').prop("disabled", true);
            $repetitionsInput.hide();

            $holdingPeriodInput.find('#holding_period_default').prop("disabled", false);
            $holdingPeriodInput.show();
        }else{
            $repetitionsInput.find('#repetitions_default').prop("disabled", false);
            $repetitionsInput.show();

            $holdingPeriodInput.find('#holding_period_default').prop("disabled", true);
            $holdingPeriodInput.hide();
        }
    });

    $(document).ready(function() {
        $typeSelect.change();
    });
</script>
@endsection