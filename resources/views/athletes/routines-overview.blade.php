@extends('layouts.main')

@section('title', trans('messages.athletes.routines.overview'))

@section('breadcrumb-link', action('App\Http\Controllers\AthletesController@show', [ $athlete->id ]))
@section('breadcrumb-title', 'Sportler')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-1">
            <h1>{{ trans('messages.athletes.routines.overview') }}</h1>
        </div>
        <div class="uk-width-1-1">
            <div uk-grid>
                <div class="uk-width-1-2">
                </div>
                <div class="uk-width-1-2">
                    <form class="uk-search uk-search-default uk-width-middle ag-search-accent uk-margin-bottom">
                        <a href="#" class="uk-search-icon-flip" uk-search-icon></a>
                        <input class="uk-search-input ag-js-filter-table" type="search" placeholder="Suche...">
                    </form>
                    <div class="ag-js-filter-label-wrapper uk-margin-bottom" data-ag-filter-for="ag-measure">
                        <h3 class="ag-filter-label-headline">Maßnahme</h3>
                        @foreach(\App\Models\MeasureTag::all() as $measure)
                            <span class="uk-label ag-js-filter-label" data-ag-filter-id="{{ $measure->id }}">{{ $measure->name }}</span>
                        @endforeach
                    </div>
                    <div class="ag-js-filter-label-wrapper uk-margin-bottom" data-ag-filter-for="ag-regions">
                        <h3 class="ag-filter-label-headline">Trainierte Region</h3>
                        @foreach(\App\Models\RegionTag::all() as $region)
                            <span class="uk-label ag-js-filter-label" data-ag-filter-id="{{ $region->id }}">{{ $region->name }}</span>
                        @endforeach
                    </div>
                    <div class="ag-js-filter-label-wrapper uk-margin-bottom" data-ag-filter-for="ag-objective">
                        <h3 class="ag-filter-label-headline">Trainingsziel</h3>
                        @foreach(\App\Models\ObjectiveTag::all() as $objective)
                            <span class="uk-label ag-js-filter-label" data-ag-filter-id="{{ $objective->id }}">{{ $objective->name }}</span>
                        @endforeach
                    </div>
                    <div class="ag-js-filter-label-wrapper uk-margin-bottom" data-ag-filter-for="ag-sport">
                        <h3 class="ag-filter-label-headline">Sportart</h3>
                        @foreach(\App\Models\AthleteGroupSport::all() as $sport)
                            <span class="uk-label ag-js-filter-label" data-ag-filter-id="{{ $sport->id }}">{{ trans($sport->i18n) }}</span>
                        @endforeach
                    </div>
                    <div class="ag-js-filter-label-wrapper uk-margin-bottom" data-ag-filter-for="ag-gender">
                        <h3 class="ag-filter-label-headline">Geschlecht</h3>
                        @foreach(\App\Models\GenderTag::all() as $gender)
                            <span class="uk-label ag-js-filter-label" data-ag-filter-id="{{ $gender->id }}">{{ $gender->name }}</span>
                        @endforeach
                    </div>
                    <div class="ag-js-filter-label-wrapper uk-margin-bottom" data-ag-filter-for="ag-age">
                        <h3 class="ag-filter-label-headline">Alter</h3>
                        @foreach(\App\Models\AgeTag::all() as $age)
                            <span class="uk-label ag-js-filter-label" data-ag-filter-id="{{ $age->id }}">{{ $age->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-width-1-2">
            <div class="uk-card uk-card-default uk-card-body uk-padding-remove">
                <table class="uk-table uk-table-divider uk-table-middle">
                    <thead>
                        <tr>
                            <th colspan="2">Zugewiesene Übungspläne</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignedRoutines as $assignedRoutine)
                            <tr>
                                <td class="ag-line-height-1 uk-table-shrink">
                                    <form class="uk-form-stacked" method="POST" action="{{ action('App\Http\Controllers\AthletesController@unassign_routine', [ $athlete->id ]) }}">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_method" value="PATCH" />
                                        <input type="hidden" name="assignedRoutine" value="{{ $assignedRoutine->id }}" />

                                        <button type="submit" class="ag-icon-fab">
                                            <i class="material-icons ag-inherit-line-height">close</i>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form class="uk-form-stacked" method="POST" action="{{ action('App\Http\Controllers\AthletesController@update_assigned_routine', [ $athlete->id ]) }}">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_method" value="PATCH" />
                                        <input type="hidden" name="assignedRoutine" value="{{ $assignedRoutine->id }}" />

                                        <div uk-grid>
                                            <div class="uk-width-expand">
                                                <div uk-grid='{"margin": "uk-margin-small-top"}'>
                                                    <div class="uk-width-1-1">
                                                        {{ $assignedRoutine->routine->translations->first()->title }}
                                                    </div>
                                                    <div class="uk-width-1-2">
                                                        <label class="uk-form-label" for="duration">Dauer (Wochen)</label>
                                                        <div class="uk-form-controls">
                                                            <input class="uk-input" id="duration" type="number" min="0" max="24" name="duration" value="{{ $assignedRoutine->duration }}">
                                                        </div>
                                                    </div>
                                                    <div class="uk-width-1-2">
                                                        <label class="uk-form-label" for="frequence">Frequenz/Woche</label>
                                                        <div class="uk-form-controls">
                                                            <select class="uk-select" id="frequence" name="frequence">
                                                                @for($i = \App\Models\Frequency::MIN; $i <= \App\Models\Frequency::MAX; $i++)
                                                                    <option value="{{ $i }}"
                                                                            {{ $i == $assignedRoutine->frequence ? 'selected' : '' }}>
                                                                    {{ $i }}
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="uk-width-1-1">
                                                        <label class="uk-form-label" for="start_date">Startdatum</label>
                                                        <div class="uk-form-controls">
                                                            <input class="uk-input" id="start_date" type="date" data-ag-max-date="{{ $maxDate }}" data-ag-min-date="{{ $minDate }}" name="start_date" value="{{ $assignedRoutine->start_date->format('Y-m-d') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="uk-width-auto uk-flex">
                                                <button type="submit" class="ag-icon-fab uk-margin-auto" title="Update values">
                                                    <i class="material-icons ag-inherit-line-height">autorenew</i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="uk-width-1-2">
            <div class="uk-card uk-card-default uk-card-body uk-padding-remove">
                <table class="uk-table uk-table-divider uk-table-middle">
                    <thead>
                    <tr>
                        <th colspan="3">Übungsplantemplates</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($availableRoutines as $routine)
                        <tr data-ag-measure="{{ $routine->measureIdAsJson() }}"
                            data-ag-regions="{{ $routine->regionIdsAsJson() }}"
                            data-ag-objective="{{ $routine->objectiveIdAsJson() }}"
                            data-ag-sport="{{ $routine->sportIdAsJson() }}"
                            data-ag-gender="{{ $routine->genderIdAsJson() }}"
                            data-ag-age="{{ $routine->ageIdAsJson() }}">
                            <td class="ag-line-height-1 uk-table-shrink">
                                <form class="uk-form-stacked" method="POST" action="{{ action('App\Http\Controllers\AthletesController@assign_routine', [ $athlete->id ]) }}">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="_method" value="PATCH" />
                                    <input type="hidden" name="routine" value="{{ $routine->id }}" />

                                    <button type="submit" class="ag-icon-fab">
                                        <i class="material-icons ag-inherit-line-height">add</i>
                                    </button>
                                </form>
                            </td>
                            <td>{{ $routine->translations->first()->title }}</td>
                            <td class="uk-table-shrink">
                                <a href="{{ action('App\Http\Controllers\RoutinesController@show', [ $routine->id ]) }}">
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
