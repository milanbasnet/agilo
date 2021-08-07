@extends('layouts.main')

@section('title', $translation->title)

@section('breadcrumb-link', action('App\Http\Controllers\WorkoutsController@index'))
@section('breadcrumb-title', 'Übungstemplates')

@section('content')
    <div class="uk-grid">
        <div class="uk-width-1-2">
            <h1>Übungstemplate</h1>

            <div class="uk-card uk-card-small uk-card-default uk-card-body ag-readonly-form">
                <div class="ag-card-nav uk-margin-bottom">
                    @if($workout->isEditable())
                    <a href="{{ action('App\Http\Controllers\WorkoutsController@edit', [$workout->id]) }}" class="ag-icon-fab uk-float-right" title="Editieren">
                        <i class="material-icons">edit</i>
                    </a>
                    @endif
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Name der Übung - Backend</p>
                    <p class="ag-readonly-form-text">{{ $translation->title }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Name der Übung - App</p>
                    <p class="ag-readonly-form-text">{{ $translation->title_in_app }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">{{ trans('messages.video.label') }}</p>
                    <video class="ag-image-border" src="{{ asset('/storage/'.$workout->video->path) }}" controls></video>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">{{ trans('messages.image.label') }}</p>
                    <img class="ag-image-border" src="{{ asset('/storage/'.$workout->image_path) }}" alt="{{ $translation->title }}"/>
                </div>

                <hr class="ag-divider">
                <p class="ag-divider-label">Standardeinstellungen</p>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Typ der Übung</p>
                    <p class="ag-readonly-form-text">{{ trans('messages.' . \App\Models\WorkoutType::label($workout->type)) }}</p>
                </div>


                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Sätze</p>
                    <p class="ag-readonly-form-text">{{ $workout->sets_default }}</p>
                </div>

                <div class="uk-margin-bottom">
                    @if($workout->type === \App\Models\WorkoutType::DYNAMIC_TYPE)
                    <p class="uk-form-label">Wiederholungen</p>
                    <p class="ag-readonly-form-text">{{ $workout->repetitions_default }}</p>
                    @elseif($workout->type === \App\Models\WorkoutType::STATIC_TYPE)
                    <p class="uk-form-label">Haltezeit in Sekunden</p>
                    <p class="ag-readonly-form-text">{{ $workout->holding_period_default }}</p>
                    @endif
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Pause in Sekunden</p>
                    <p class="ag-readonly-form-text">{{ $workout->rest_default }}</p>
                </div>

                @if($workout->equipment_needed && $workout->equipment)
                    <div class="uk-margin-bottom">
                        <p class="uk-form-label">Material</p>
                        <p class="ag-readonly-form-text">{{ $workout->equipment->name }}</p>
                    </div>

                    <div class="uk-margin-bottom">
                        <p class="uk-form-label">Gewicht des Materials [kg]</p>
                        <p class="ag-readonly-form-text">{{ $workout->weight_default }}</p>
                    </div>
                @endif

                <hr class="ag-divider">
                <p class="ag-divider-label">Beschreibung</p>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">{{trans('messages.starting_position.label')}}</p>
                    <p class="ag-readonly-form-text">{{ $translation->starting_position }}</p>
                </div>
                <div class="uk-margin-bottom">
                    <p class="uk-form-label">{{trans('messages.execution.label')}}</p>
                    <p class="ag-readonly-form-text">{{ $translation->execution }}</p>
                </div>
                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Tempo</p>
                    <p class="ag-readonly-form-text">{{ $workout->paceTag->name }}</p>
                </div>
                <div class="uk-margin-bottom">
                    <p class="uk-form-label">{{trans('messages.hints.label')}}</p>
                    <p class="ag-readonly-form-text">{{ $translation->hints }}</p>
                </div>
                <div class="uk-margin-bottom">
                    <p class="uk-form-label">{{trans('messages.difficulty.label')}}</p>
                    <p class="ag-readonly-form-text">{{ $translation->difficulty }}</p>
                </div>

                <hr class="ag-divider">
                <p class="ag-divider-label">Tags</p>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Regionen</p>
                    <ul class="ag-readonly-form-text">
                        @foreach($workout->regionTags as $regionTag)
                            <li>{{  $regionTag->name }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Art</p>
                    <ul class="ag-readonly-form-text">
                        @foreach($workout->typeTags as $typeTag)
                            <li>{{  $typeTag->name }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Level</p>
                    <p class="ag-readonly-form-text">{{$workout->levelTag->name}}</p>
                </div>
            </div>
        </div>
    </div>
@endsection