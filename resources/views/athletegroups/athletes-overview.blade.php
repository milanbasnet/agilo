@extends('layouts.main')

@section('title', trans('messages.groups.athletes.overview'))

@section('breadcrumb-link', action('App\Http\Controllers\AthleteGroupsController@show', [ $group->id ]))
@section('breadcrumb-title', 'Gruppe')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-1">
            <h1>{{ trans('messages.groups.athletes.overview') }}</h1>
        </div>
        <div class="uk-width-1-1">
            <div uk-grid>
                <div class="uk-width-1-2">
                </div>
                <div class="uk-width-1-2">
                    <form class="uk-search uk-search-default uk-width-middle ag-search-accent">
                        <a href="#" class="uk-search-icon-flip" uk-search-icon></a>
                        <input class="uk-search-input ag-js-filter-table" type="search" placeholder="Suche...">
                    </form>
                </div>
            </div>
        </div>
        <div class="uk-width-1-2">
            <div class="uk-card uk-card-default uk-card-body uk-padding-remove">
                <table class="uk-table uk-table-divider uk-table-middle">
                    <thead>
                        <tr>
                            <th colspan="3">Mitglieder</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($group->athletes) < 1)
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                        @foreach($group->athletes as $athlete)
                            <tr {!! !$athlete->active ? "class=ag-inactive" : "" !!}>
                                <td class="ag-line-height-1 uk-table-shrink">
                                    <form class="uk-form-stacked" method="POST" action="{{ action('App\Http\Controllers\AthleteGroupsController@unassign_athlete', [ $group->id ]) }}">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_method" value="PATCH" />
                                        <input type="hidden" name="athlete" value="{{ $athlete->id }}" />

                                        <button type="submit" class="ag-icon-fab">
                                            <i class="material-icons ag-inherit-line-height">close</i>
                                        </button>
                                    </form>
                                </td>
                                <td>{{ $athlete->last_name }}, {{ $athlete->first_name }}</td>
                                <td class="uk-table-shrink">
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
            <div class="uk-card uk-card-default uk-card-body uk-padding-remove">
                <table class="uk-table uk-table-divider uk-table-middle">
                    <thead>
                    <tr>
                        <th colspan="3">Sportler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($athletes) < 1)
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                    @foreach($athletes as $athlete)
                        <tr>
                            <td class="ag-line-height-1 uk-table-shrink">
                                <form class="uk-form-stacked" method="POST" action="{{ action('App\Http\Controllers\AthleteGroupsController@assign_athlete', [ $group->id ]) }}">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="_method" value="PATCH" />
                                    <input type="hidden" name="athlete" value="{{ $athlete->id }}" />

                                    <button type="submit" class="ag-icon-fab">
                                        <i class="material-icons ag-inherit-line-height">add</i>
                                    </button>
                                </form>
                            </td>
                            <td>{{ $athlete->last_name }}, {{ $athlete->first_name }}</td>
                            <td class="uk-table-shrink">
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
