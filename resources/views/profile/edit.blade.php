@extends('layouts.main')

@section('title', trans('messages.profile.edit'))

@section('breadcrumb-link', action('App\Http\Controllers\ProfileController@show'))
@section('breadcrumb-title', 'Profil')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-2">
            <h1>{{ trans('messages.profile.edit') }}</h1>

            @if(Auth::user()->initial_login)
                <div class="uk-card uk-card-small uk-card-default uk-card-body uk-margin-medium-bottom">
                    <h3>Bitte Passwort ändern</h3>
                    <p>Bitte ändern Sie das initial vergebene Passwort.</p>
                </div>
            @endif

            <div class="uk-card uk-card-small uk-card-default uk-card-body">

                <form class="uk-form-stacked" method="POST" action="{{ action('App\Http\Controllers\ProfileController@update') }}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="PATCH" />

                    @if(Auth::user()->initial_login)
                        <input type="hidden" name="initial_login" value="false" />
                    @endif

                    <div class="ag-card-nav uk-margin-bottom">
                        <a href="{{ action('App\Http\Controllers\ProfileController@show') }}" class="ag-icon-fab" title="Zurück">
                            <i class="material-icons">close</i>
                        </a>

                        <button type="submit" class="ag-icon-fab uk-float-right" title="Speichern">
                            <i class="material-icons">check</i>
                        </button>
                    </div>

                    <div class="uk-margin-bottom">
                        <label class="uk-form-label" for="first_name">Vorname</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="first_name" name="first_name" value="{{ old('first_name') }}" {{ $user->isAdmin() ? 'readonly' : '' }}>
                        </div>
                    </div>

                    <div class="uk-margin-bottom">
                        <label class="uk-form-label" for="last_name">Nachname</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="last_name" name="last_name" value="{{ old('last_name') }}" {{ $user->isAdmin() ? 'readonly' : '' }}>
                        </div>
                    </div>

                    <div class="uk-margin-bottom">
                        <label class="uk-form-label" for="email">Email</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="email" name="email" type="email" value="{{ old('email') }}" readonly>
                        </div>
                    </div>

                    <div class="uk-margin-bottom">
                        <label class="uk-form-label" for="phone">Telefon</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="phone" name="phone" type="tel" value="{{ old('phone') }}" {{ $user->isAdmin() ? 'readonly' : '' }}>
                        </div>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="old_password">Altes Passwort</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="old_password" name="old_password" type="password">
                        </div>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="new_password">Neues Passwort</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="new_password" name="new_password" type="password">
                        </div>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="password_confirm">Neues Passwort wiederholen</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="password_confirm" name="password_confirm" type="password">
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
