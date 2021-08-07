@extends('layouts.main')

@section('title', trans('messages.groups.edit'))

@section('breadcrumb-link', action('App\Http\Controllers\AthleteGroupsController@show', [ $group->id ]))
@section('breadcrumb-title', 'Gruppe')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-1">
            <h1>{{ trans('messages.groups.edit') }}</h1>
        </div>
        <div class="uk-width-1-2">
            <div class="uk-card uk-card-small uk-card-default uk-card-body ag-readonly-form">
                <form class="uk-form-stacked" method="POST" action="{{ action('App\Http\Controllers\AthleteGroupsController@update', [ $group->id ]) }}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="PATCH" />

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
