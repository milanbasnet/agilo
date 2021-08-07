@extends('layouts.main')

@section('title', trans('messages.profile'))

@section('breadcrumb-link', action('App\Http\Controllers\DashboardController@index'))
@section('breadcrumb-title', 'Dashboard')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-2">
            <h1>{{ trans('messages.profile') }}</h1>

            <div class="uk-card uk-card-small uk-card-default uk-card-body ag-readonly-form">
                <div class="ag-card-nav uk-margin-bottom">
                    <a href="{{ action('App\Http\Controllers\ProfileController@edit') }}" class="ag-icon-fab uk-float-right" title="Bearbeiten">
                        <i class="material-icons">edit</i>
                    </a>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Vorname</p>
                    <p class="ag-readonly-form-text">{{ $user->first_name }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Nachname</p>
                    <p class="ag-readonly-form-text">{{ $user->last_name }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Email</p>
                    <p class="ag-readonly-form-text">{{ $user->email }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Telefon</p>
                    <p class="ag-readonly-form-text">{{ $user->phone }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection