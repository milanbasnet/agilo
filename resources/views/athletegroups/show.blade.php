@extends('layouts.main')

@section('title', trans('messages.group'))

@section('breadcrumb-link', action('App\Http\Controllers\AthletesGroupsOverviewController@index'))
@section('breadcrumb-title', 'Sportler & Gruppen')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-1">
            <h1>{{ trans('messages.group') }}</h1>
        </div>
        <div class="uk-width-1-2">
            <div class="uk-card uk-card-small uk-card-default uk-card-body ag-readonly-form">
                <div class="ag-card-nav uk-margin-bottom">
                    <a href="{{ action('App\Http\Controllers\AthletesGroupsOverviewController@index') }}" class="ag-icon-fab" title="Zurück">
                        <i class="material-icons">chevron_left</i>
                    </a>

                    <div class="uk-float-right">
                        <form method="POST" class="uk-display-inline-block" action="{{ action('App\Http\Controllers\AthleteGroupsController@destroy', [ $group->id ]) }}">
                            {!! csrf_field() !!}
                            <input type="hidden" name="_method" value="DELETE" />

                            <button type="submit" class="ag-icon-fab uk-float-left" title="Entfernen">
                                <i class="material-icons">delete</i>
                            </button>
                        </form>

                        <a href="{{ action('App\Http\Controllers\AthleteGroupsController@edit', [ $group->id ]) }}" class="ag-icon-fab uk-margin-left" title="Bearbeiten">
                            <i class="material-icons">create</i>
                        </a>
                    </div>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Name</p>
                    <p class="ag-readonly-form-text">{{ $group->title }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Beschreibung</p>
                    <p class="ag-readonly-form-text">{{ $group->description }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Sportart</p>
                    <p class="ag-readonly-form-text">{{ trans($group->sport->i18n) }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Niveau</p>
                    <p class="ag-readonly-form-text">{{ trans($group->level->i18n) }}</p>
                </div>


                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Trainingseinheiten/Woche</p>
                    <p class="ag-readonly-form-text">{{ $group->workouts_per_week }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Geschlecht</p>
                    <p class="ag-readonly-form-text">{{ $group->sex() }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Alter der Sportler</p>
                    <p class="ag-readonly-form-text">{{ $group->age() }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Betreuer</p>
                    <ul class="ag-readonly-form-text">
                        @foreach($group->users as $user)
                            <li>{{  $user->last_name }}, {{  $user->first_name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="uk-width-1-2">
            <div class="uk-card uk-card-small uk-card-default uk-card-body">
                <div class="ag-card-nav uk-margin-bottom">
                    <a href="{{ action('App\Http\Controllers\AthleteGroupsController@routines', [ $group->id ]) }}" class="ag-icon-fab uk-float-right" title="Bearbeiten">
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
        </div>
        <div class="uk-width-1-2">
            <div class="uk-card uk-card-small uk-card-default uk-card-body">
                <div class="ag-card-nav uk-margin-bottom">
                    <a href="{{ action('App\Http\Controllers\AthleteGroupsController@athletes', [ $group->id ]) }}" class="ag-icon-fab uk-float-right" title="Bearbeiten">
                        <i class="material-icons">create</i>
                    </a>
                </div>

                <table class="uk-table uk-table-divider uk-table-middle ag-table-bordered">
                    <thead>
                    <tr>
                        <th>Mitglieder</th>
                        <th class="uk-table-shrink"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($group->athletes) < 1)
                        <tr>
                            <td>-</td>
                            <td></td>
                        </tr>
                    @endif
                    @foreach($group->athletes as $athlete)
                        <tr>
                            <td>{{ $athlete->last_name }}, {{ $athlete->first_name }}</td>
                            <td>
                                <a href="{{ action('App\Http\Controllers\AthletesController@show', [ $athlete->id ]) }}">
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