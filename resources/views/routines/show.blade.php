@extends('layouts.main')

@section('title', $routine->translations->first()->title)

@section('breadcrumb-link', action('App\Http\Controllers\RoutinesController@index'))
@section('breadcrumb-title', 'Übungspläne')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-1">
            <h1>{{ trans('messages.routine') }}</h1>
        </div>
        <div class="uk-width-1-2">
            <div class="uk-card uk-card-small uk-card-default uk-card-body ag-readonly-form">
                @if($routine->isEditable())
                    <div class="ag-card-nav uk-margin-bottom">
                        <a href="{{ action('App\Http\Controllers\RoutinesController@edit', [ $routine->id ] ) }}" class="ag-icon-fab uk-float-right" title="Editieren">
                            <i class="material-icons">edit</i>
                        </a>
                    </div>
                @endif

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">{{ trans('messages.routines.title.label') }}</p>
                    <p class="ag-readonly-form-text">{{ $routine->translations->first()->title }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Erstellt von</p>
                    <p class="ag-readonly-form-text">{{ $routine->user->first_name }} {{ $routine->user->last_name }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Sportart</p>
                    <p class="ag-readonly-form-text">{{ trans($routine->sport->i18n) }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Maßnahme</p>
                    <p class="ag-readonly-form-text">{{ $routine->measureTag->name }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Trainierte Region</p>
                    <ul class="ag-readonly-form-text">
                        @foreach($routine->regionTags as $region)
                            <li>{{ $region->name }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">{{ trans('messages.routines.injuries.label') }}</p>
                    <p class="ag-readonly-form-text">{{ $routine->translations->first()->injuries }}</p>
                </div>

                <div uk-grid='{"margin": ""}'>
                    <div class="uk-width-1-2">
                        <div class="uk-margin-bottom">
                            <p class="uk-form-label">Trainingsziel</p>
                            <p class="ag-readonly-form-text">{{ $routine->objectiveTag->name }}</p>
                        </div>
                    </div>
                    <div class="uk-width-1-2">
                        <div class="uk-margin-bottom">
                            <p class="uk-form-label">Level</p>
                            <p class="ag-readonly-form-text">{{ $routine->levelTag->name }}</p>
                        </div>
                    </div>

                    <div class="uk-width-1-2">
                        <div class="uk-margin-bottom">
                            <p class="uk-form-label">Geschlecht</p>
                            <p class="ag-readonly-form-text">{{ $routine->genderTag->name }}</p>
                        </div>
                    </div>
                    <div class="uk-width-1-2">
                        <div class="uk-margin-bottom">
                            <p class="uk-form-label">Alter</p>
                            <p class="ag-readonly-form-text">{{ $routine->ageTag->name }}</p>
                        </div>
                    </div>
                    <div class="uk-width-1-2">
                        <div class="uk-margin-bottom">
                            <p class="uk-form-label">Frequenz</p>
                            <p class="ag-readonly-form-text">{{ \App\Models\Frequency::label($routine->frequence_default) }}</p>
                        </div>
                    </div>
                    <div class="uk-width-1-2">
                        <div class="uk-margin-bottom">
                            <p class="uk-form-label">Dauer</p>
                            <p class="ag-readonly-form-text">{{ $routine->duration_default }} Wochen</p>
                        </div>
                    </div>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Link zu PubMed</p>
                    <p class="ag-readonly-form-text">{{ $routine->pubmed_link }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Anmerkungen</p>
                    <p class="ag-readonly-form-text">{{ $routine->translations->first()->description }}</p>
                </div>
            </div>
        </div>
        <div class="uk-width-1-2">
            <div class="uk-card uk-card-small uk-card-default uk-card-body ag-readonly-form uk-margin-bottom">
                <!-- workout routine select -->
                @if($routine->isEditable())
                <div class="ag-card-nav uk-margin-bottom">
                    <a href="{{ action('App\Http\Controllers\RoutinesController@workouts', [ $routine->id ]) }}" class="ag-icon-fab uk-float-right" title="Bearbeiten">
                        <i class="material-icons">create</i>
                    </a>
                </div>
                @endif

                <table class="uk-table uk-table-divider uk-table-middle ag-table-bordered">
                    <thead>
                    <tr>
                        <th>Zugewiesene Übungen</th>
                        <th class="uk-table-shrink"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($routine->parameterizedWorkouts as $paramWorkout)
                        <tr>
                            <td>{{ $paramWorkout->workout->translations->first()->title }}</td>
                            <td>
                                <a href="{{ action('App\Http\Controllers\WorkoutsController@show', [ $paramWorkout->workout->id ]) }}">
                                    <i class="material-icons ag-inherit-line-height ag-color-accent">chevron_right</i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection