@extends('layouts.main')

@section('title', trans('messages.therapists.create'))

@section('breadcrumb-link', action('App\Http\Controllers\TherapistsController@index'))
@section('breadcrumb-title', 'Betreuer')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-2">
            <h1>{{ trans('messages.therapists.create') }}</h1>

            <div class="uk-card uk-card-small uk-card-default uk-card-body">

                <form class="uk-form-stacked" method="POST" action="{{ action('App\Http\Controllers\TherapistsController@store') }}">
                    {!! csrf_field() !!}

                    <div class="ag-card-nav uk-margin-bottom">
                        <a href="{{ action('App\Http\Controllers\TherapistsController@index') }}" class="ag-icon-fab" title="Zurück">
                            <i class="material-icons">close</i>
                        </a>

                        <button type="submit" class="ag-icon-fab uk-float-right" title="Speichern">
                            <i class="material-icons">check</i>
                        </button>
                    </div>

                    <div class="uk-margin-bottom">
                        <label class="uk-form-label" for="first_name">Vorname</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="first_name" name="first_name" value="{{ old('first_name') }}">
                        </div>
                    </div>

                    <div class="uk-margin-bottom">
                        <label class="uk-form-label" for="last_name">Nachname</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="last_name" name="last_name" value="{{ old('last_name') }}">
                        </div>
                    </div>

                    <div class="uk-margin-bottom">
                        <label class="uk-form-label" for="email">Email</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="email" name="email" type="email" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="uk-margin-bottom">
                        <label class="uk-form-label" for="phone">Telefon</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="phone" name="phone" type="tel" value="{{ old('phone') }}">
                        </div>
                    </div>

                    <div class="uk-margin-bottom">
                        <label class="uk-form-label" for="level">Rolle</label>
                        <div class="uk-form-controls">
                            <select class="uk-select" id="role" name="role">
                                <option value="" disabled {{ old('role') ? '' : 'selected' }}>Rolle auswählen</option>
                                @foreach(\App\Models\TherapistRole::all() as $role)
                                    <option value="{{ $role->id }}"
                                            {{ $role->id == old('role') ? 'selected' : '' }}>
                                        {{ trans($role->i18n) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
