@extends('layouts.main')

@section('title', trans('messages.groups.create'))

@section('breadcrumb-link', action('App\Http\Controllers\AthletesGroupsOverviewController@index'))
@section('breadcrumb-title', 'Sportler & Gruppen')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-1">
            <h1>{{ trans('messages.group.create') }}</h1>
        </div>
        <div class="uk-width-1-2">
            <div class="uk-card uk-card-small uk-card-default uk-card-body ag-readonly-form">
                <form class="uk-form-stacked" method="POST" action="{{ action('App\Http\Controllers\AthleteGroupsController@store') }}">
                    {!! csrf_field() !!}

                    @include('athletegroups.partials.athletegroup-form')
                </form>
            </div>
        </div>
        <div class="uk-width-1-2">
        </div>
        <div class="uk-width-1-2">
            <div class="uk-card uk-card-small uk-card-default uk-card-body">
                <div class="ag-card-nav uk-margin-bottom">
                    <span class="ag-icon-fab uk-float-right ag-icon-disabled" title="Bearbeiten">
                        <i class="material-icons">create</i>
                    </span>
                </div>

                <table class="uk-table uk-table-divider uk-table-middle ag-table-bordered">
                    <thead>
                    <tr>
                        <th>Mitglieder</th>
                        <th class="uk-table-shrink"></th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>-</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
