@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-1">
            <h1 class="ag-hero">Willkommen zurück {{ $user->first_name . ' ' . $user->last_name }}!<i class="material-icons ag-hero__triangle">network_cell</i></h1>
        </div>
        @if($user->office->logo_path)
            <div class="uk-width-1-4">
                <div class="uk-card uk-card-small uk-card-default uk-card-body">
                    <img src="{{ asset('/storage/'.$user->office->logo_path) }}" alt="Logo"/>
                </div>
            </div>
        @endif
        <div class="uk-width-3-4">
            <div class="uk-card uk-card-small uk-card-default uk-card-body ag-dashboard-cta-items">
                <div uk-grid>
                    @if($user->isAdmin())
                        <div class="uk-width-1-3">
                            <a href="{{ route('offices.create')}}" class="uk-button uk-button-default ag-special-button ag-special-button--accent">
                                <span>Mandant anlegen</span>
                                <i class="material-icons">chevron_right</i>
                            </a>
                        </div>
                        <div class="uk-width-1-3">
                            <a href="{{ action('App\Http\Controllers\WorkoutsController@create') }}" class="uk-button uk-button-default ag-special-button ag-special-button--accent">
                                <span>Übung anlegen</span>
                                <i class="material-icons">chevron_right</i>
                            </a>
                        </div>
                    @endif
                    @if($user->isOfficeAdmin() || $user->isTherapist())
                        @if($user->isOfficeAdmin())
                            <div class="uk-width-1-3">
                                <a href="{{ action('App\Http\Controllers\TherapistsController@create') }}" class="uk-button uk-button-default ag-special-button ag-special-button--accent">
                                    <span>Betreuer anlegen</span>
                                    <i class="material-icons">chevron_right</i>
                                </a>
                            </div>
                        @endif
                        <div class="uk-width-1-3">
                            <a href="{{ action('App\Http\Controllers\AthletesController@create') }}" class="uk-button uk-button-default ag-special-button ag-special-button--accent">
                                <span>Sportler anlegen</span>
                                <i class="material-icons">chevron_right</i>
                            </a>
                        </div>
                        <div class="uk-width-1-3">
                            <a href="{{ action('App\Http\Controllers\AthleteGroupsController@create') }}" class="uk-button uk-button-default ag-special-button ag-special-button--accent">
                                <span>Gruppe anlegen</span>
                                <i class="material-icons">chevron_right</i>
                            </a>
                        </div>
                        <div class="uk-width-1-3">
                            <a href="{{ action('App\Http\Controllers\RoutinesController@create') }}" class="uk-button uk-button-default ag-special-button ag-special-button--accent">
                                <span>Übungsplan anlegen</span>
                                <i class="material-icons">chevron_right</i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="uk-width-1-2">
            @foreach($user->groups as $group)
                <div class="uk-card uk-card-small uk-card-default uk-card-body uk-margin-medium-bottom">
                    <div class="uk-card-header ag-card-header--with-fab" uk-grid>
                        <h3 class="uk-width-expand">{{ $group->title }}</h3>
                        <div class="uk-width-auto">
                            <a href="{{ action('App\Http\Controllers\AthleteGroupsController@show', [ $group->id ]) }}" class="ag-icon-fab" title="Neu">
                                <i class="material-icons">chevron_right</i>
                            </a>
                        </div>
                    </div>
                    <div class="uk-card-body uk-padding-remove">
                        {{ $group->athleteNames() }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection