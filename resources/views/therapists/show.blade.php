@extends('layouts.main')

@section('title', trans('messages.therapists'))

@section('breadcrumb-link', action('App\Http\Controllers\TherapistsController@index'))
@section('breadcrumb-title', 'Betreuer')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-2">
            <h1>{{ trans('messages.therapists') }}</h1>

            <div class="uk-card uk-card-small uk-card-default uk-card-body ag-readonly-form {{ !$therapist->active ? "ag-inactive" : "" }}">
                <div class="ag-card-nav uk-margin-bottom">
                    @if($therapist->active)
                        <form method="POST" action="{{ action('App\Http\Controllers\TherapistsController@deactivate', [ $therapist->id ]) }}">
                            {!! csrf_field() !!}
                            <input type="hidden" name="_method" value="PATCH" />

                            <a href="{{ action('App\Http\Controllers\TherapistsController@index') }}" class="ag-icon-fab" title="Zurück">
                                <i class="material-icons">chevron_left</i>
                            </a>

                            <button type="submit" class="ag-icon-fab uk-float-right" title="Deaktivieren">
                                <i class="material-icons">visibility_off</i>
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ action('App\Http\Controllers\TherapistsController@activate', [ $therapist->id ]) }}">
                            {!! csrf_field() !!}
                            <input type="hidden" name="_method" value="PATCH" />

                            <a href="{{ action('App\Http\Controllers\TherapistsController@index') }}" class="ag-icon-fab" title="Zurück">
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
                    <p class="ag-readonly-form-text">{{ $therapist->first_name }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Nachname</p>
                    <p class="ag-readonly-form-text">{{ $therapist->last_name }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Email</p>
                    <p class="ag-readonly-form-text">{{ $therapist->email }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Telefon</p>
                    <p class="ag-readonly-form-text">{{ $therapist->phone }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Rolle</p>
                    <p class="ag-readonly-form-text">{{ trans($therapist->therapistRole->i18n) }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection