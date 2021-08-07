@extends('layouts.main')

@section('title', trans('messages.offices'))

@section('breadcrumb-link', action('App\Http\Controllers\DashboardController@index'))
@section('breadcrumb-title', 'Dashboard')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-2">
            <h1>{{ trans('messages.offices') }}</h1>

            <div class="uk-margin-bottom" uk-grid>
                <div>
                    <a href="{{ action('App\Http\Controllers\OfficesController@create') }}" class="ag-icon-fab" title="Neu">
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
                        <th class="uk-table-shrink"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($offices as $office)
                        <tr {!! !$office->active ? "class=ag-inactive" : "" !!}>
                            <td>{{ $office->name }}</td>
                            <td>
                                <a href="{{ action('App\Http\Controllers\OfficesController@show', [ $office->id ]) }}">
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
