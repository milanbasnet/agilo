@extends('layouts.main')

@section('title', trans('messages.athletesgroupsoverview'))

@section('breadcrumb-link', action('App\Http\Controllers\DashboardController@index'))
@section('breadcrumb-title', 'Dashboard')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-2">
            <h1>{{ trans('messages.athletes') }}</h1>

            <div class="uk-margin-bottom" uk-grid>
                <div>
                    <a href="{{ action('App\Http\Controllers\AthletesController@create') }}" class="ag-icon-fab" title="Neu">
                        <i class="material-icons">add</i>
                    </a>
                </div>

                <div class="uk-width-expand">
                    <form class="uk-search uk-search-default uk-width-middle ag-search-accent">
                        <a href="#" class="uk-search-icon-flip" uk-search-icon></a>
                        <input class="uk-search-input ag-js-filter-table" type="search" placeholder="Sportler/Gruppen suchen...">
                    </form>
                </div>
            </div>

            <div class="uk-card uk-card-default uk-card-body uk-padding-remove">
                <table class="uk-table uk-table-divider uk-table-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Geburtstag</th>
                            <th>Gruppe</th>
                            <th class="uk-table-shrink"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($athletes) < 1)
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                        @foreach($athletes as $athlete)
                            <tr {!! !$athlete->active ? "class=ag-inactive" : "" !!}>
                                <td>{{ $athlete->last_name }}, {{ $athlete->first_name }}</td>
                                <td>{{ $athlete->birth->format('d.m.Y') }}</td>
                                <td class="uk-text-truncate">{{ $athlete->groupNames() }}</td>
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

        <div class="uk-width-1-2">
            <h1>{{ trans('messages.groups') }}</h1>

            <div class="uk-margin-bottom" uk-grid>
                <div>
                    <a href="{{ action('App\Http\Controllers\AthleteGroupsController@create') }}" class="ag-icon-fab" title="Neu">
                        <i class="material-icons">add</i>
                    </a>
                </div>
            </div>

            <div class="uk-card uk-card-default uk-card-body uk-padding-remove">
                <table class="uk-table uk-table-divider uk-table-middle">
                    <thead>
                        <tr>
                            <th>Gruppe</th>
                            <th class="uk-table-shrink"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($groups) < 1)
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                        @foreach($groups as $group)
                            <tr>
                                <td>{{ $group->title }}</td>
                                <td>
                                    <a href="{{ action('App\Http\Controllers\AthleteGroupsController@show', [ $group->id ]) }}">
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
