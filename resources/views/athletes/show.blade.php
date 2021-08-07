@extends('layouts.main')

@section('title', trans('messages.athlete'))

@section('breadcrumb-link', action('App\Http\Controllers\AthletesGroupsOverviewController@index'))
@section('breadcrumb-title', 'Sportler & Gruppen')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-1">
            <h1>{{ trans('messages.athlete') }}</h1>
        </div>
        <div class="uk-width-1-2">
            <div class="uk-card uk-card-small uk-card-default uk-card-body ag-readonly-form {{ !$athlete->active ? "ag-inactive" : "" }}">
                <div class="ag-card-nav uk-margin-bottom">
                    @if($athlete->active)
                        <form method="POST" action="{{ action('App\Http\Controllers\AthletesController@deactivate', [ $athlete->id ]) }}">
                            {!! csrf_field() !!}
                            <input type="hidden" name="_method" value="PATCH" />

                            <a href="{{ action('App\Http\Controllers\AthletesGroupsOverviewController@index') }}" class="ag-icon-fab" title="Zurück">
                                <i class="material-icons">chevron_left</i>
                            </a>

                            <button type="submit" class="ag-icon-fab uk-float-right" title="Deaktivieren">
                                <i class="material-icons">visibility_off</i>
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ action('App\Http\Controllers\AthletesController@activate', [ $athlete->id ]) }}">
                            {!! csrf_field() !!}
                            <input type="hidden" name="_method" value="PATCH" />

                            <a href="{{ action('App\Http\Controllers\AthletesGroupsOverviewController@index') }}" class="ag-icon-fab" title="Zurück">
                                <i class="material-icons">chevron_left</i>
                            </a>

                            <button type="submit" class="ag-icon-fab uk-float-right" title="Aktivieren">
                                <i class="material-icons">visibility</i>
                            </button>
                        </form>
                    @endif
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Vorname</p>
                    <p class="ag-readonly-form-text">{{ $athlete->first_name }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Nachname</p>
                    <p class="ag-readonly-form-text">{{ $athlete->last_name }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Geburtstag</p>
                    <p class="ag-readonly-form-text">{{ $athlete->birth->format('d.m.Y') }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Email</p>
                    <p class="ag-readonly-form-text">{{ $athlete->email }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Geschlecht</p>
                    <p class="ag-readonly-form-text">{{ trans('messages.' . App\Models\Sex::label($athlete->sex)) }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Gruppen</p>
                    <ul class="uk-list ag-group-list">
                        @foreach($athlete->groups as $group)
                            <li>
                                <a href="{{ action('App\Http\Controllers\AthleteGroupsController@show', [ $group->id ]) }}">{{$group->title}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>


            </div>
        </div>
        <div class="uk-width-1-2">
            @if(Auth::user()->isTherapist())
                <div class="uk-card uk-card-small uk-card-default uk-card-body ag-readonly-form uk-margin-bottom">
                        <a href="{{ action('App\Http\Controllers\HealthRecordController@show', [ $athlete->id ]) }}" class="uk-button uk-button-default ag-special-button uk-float-right">
                            <span>Sportlerakte</span>
                            <i class="material-icons">chevron_right</i>
                        </a>
                </div>
            @endif

            <div class="uk-card uk-card-small uk-card-default uk-card-body ag-readonly-form uk-margin-bottom">
                <!-- workout routine select -->
                <div class="ag-card-nav uk-margin-bottom">
                    <a href="{{ action('App\Http\Controllers\AthletesController@routines', [ $athlete->id ]) }}" class="ag-icon-fab uk-float-right" title="Bearbeiten">
                        <i class="material-icons">create</i>
                    </a>
                </div>

                <table class="uk-table uk-table-divider uk-table-middle ag-table-bordered">
                    <thead>
                    <tr>
                        <th>Zugewiesene Übungspläne</th>
                        <th class="uk-table-shrink"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($assignedRoutines as $assignedRoutine)
                        <tr>
                            <td>{{ $assignedRoutine->routine->translations->first()->title }}</td>
                            <td>
                                <a href="{{ action('App\Http\Controllers\RoutinesController@show', [ $assignedRoutine->routine->id ]) }}">
                                    <i class="material-icons ag-inherit-line-height ag-color-accent">chevron_right</i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="uk-card uk-card-small uk-card-default uk-card-body">
                <table class="uk-table uk-table-divider uk-table-middle ag-table-bordered">
                    <thead>
                    <tr>
                        <th>Zugewiesene Übungspläne (Gruppen)</th>
                        <th class="uk-table-shrink"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($assignedRoutinesByGroup as $assignedRoutine)
                        <tr>
                            <td>{{ $assignedRoutine->routine->translations->first()->title }}</td>
                            <td>
                                <a href="{{ action('App\Http\Controllers\RoutinesController@show', [ $assignedRoutine->routine->id ]) }}">
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