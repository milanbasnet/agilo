@extends('layouts.main')

@section('title', trans('messages.therapists'))

@section('breadcrumb-link', action('App\Http\Controllers\DashboardController@index'))
@section('breadcrumb-title', 'Dashboard')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-2">
            <h1>{{ trans('messages.therapists') }}</h1>

            <div class="uk-margin-bottom" uk-grid>
                <div>
                    <a href="{{ action('App\Http\Controllers\TherapistsController@create') }}" class="ag-icon-fab" title="Neu">
                        <i class="material-icons">add</i>
                    </a>
                </div>

                <div class="uk-width-expand">
                    <form class="uk-search uk-search-default uk-width-middle ag-search-accent">
                        <a href="#" class="uk-search-icon-flip" uk-search-icon></a>
                        <input class="uk-search-input ag-js-filter-table" type="search" placeholder="Suche...">
                    </form>
                </div>
            </div>

            <div class="uk-card uk-card-default uk-card-body uk-padding-remove">
                <table class="uk-table uk-table-divider uk-table-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Gruppen</th>
                            <th class="uk-table-shrink"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($therapists) < 1)
                            <tr>
                                <td>-</td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                        @foreach($therapists as $therapist)
                            <tr {!! !$therapist->active ? "class=ag-inactive" : "" !!}>
                                <td>{{ $therapist->last_name }}, {{ $therapist->first_name }}</td>
                                <td class="uk-text-truncate">{{ $therapist->groupNames() }}</td>
                                <td>
                                    <a href="{{ action('App\Http\Controllers\TherapistsController@show', [ $therapist->id ]) }}">
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
