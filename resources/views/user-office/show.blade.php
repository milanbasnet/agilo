@extends('layouts.main')

@section('title', trans('messages.office'))

@section('breadcrumb-link', action('App\Http\Controllers\DashboardController@index'))
@section('breadcrumb-title', 'Dashboard')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-2">
            <h1>{{ trans('messages.office') }}</h1>

            <div class="uk-card uk-card-small uk-card-default uk-card-body ag-readonly-form">
                <div class="ag-card-nav uk-margin-bottom">
                    @if (Auth::user()->isOfficeAdmin())
                        <a href="{{ action('App\Http\Controllers\UserOfficeController@edit') }}" class="ag-icon-fab uk-float-right" title="Editieren">
                            <i class="material-icons">create</i>
                        </a>
                    @endif
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Name des Mandanten</p>
                    <p class="ag-readonly-form-text">{{ $office->name }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Name der Kontaktperson</p>
                    <p class="ag-readonly-form-text">{{ $office->contact }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Mandantentyp</p>
                    <p class="ag-readonly-form-text">{{ trans($office->type->i18n) }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Email</p>
                    <p class="ag-readonly-form-text">{{ $office->email }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Telefon</p>
                    <p class="ag-readonly-form-text">{{ $office->phone }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Sportarten</p>
                    <ul class="ag-readonly-form-text">
                        @foreach($office->sports as $sport)
                            <li>{{  trans($sport->i18n) }}</li>
                        @endforeach
                    </ul>
                </div>

                @if($office->logo_path)
                    <div class="uk-margin-bottom">
                        <p class="uk-form-label">Logo</p>
                        <img class="ag-image-border" src="{{ asset('/storage/'.$office->logo_path) }}" alt="Logo"/>
                    </div>
                @endif

                <hr class="ag-divider">
                <p class="ag-divider-label">Adresse</p>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Straße</p>
                    <p class="ag-readonly-form-text">{{ $office->street }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Postleitzahl</p>
                    <p class="ag-readonly-form-text">{{ $office->zip_code }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Stadt</p>
                    <p class="ag-readonly-form-text">{{ $office->city }}</p>
                </div>

                <div class="uk-margin-bottom">
                    <p class="uk-form-label">Land</p>
                    <p class="ag-readonly-form-text">{{ $office->country }}</p>
                </div>

                @if($office->has_billing_address)
                    <hr class="ag-divider">
                    <p class="ag-divider-label">Rechnungsadresse</p>

                    <div class="uk-margin-bottom">
                        <p class="uk-form-label">Geschäftsname</p>
                        <p class="ag-readonly-form-text">{{ $office->billing_name }}</p>
                    </div>

                    <div class="uk-margin-bottom">
                        <p class="uk-form-label">Straße</p>
                        <p class="ag-readonly-form-text">{{ $office->billing_street }}</p>
                    </div>

                    <div class="uk-margin-bottom">
                        <p class="uk-form-label">Postleitzahl</p>
                        <p class="ag-readonly-form-text">{{ $office->billing_zip_code }}</p>
                    </div>

                    <div class="uk-margin-bottom">
                        <p class="uk-form-label">Stadt</p>
                        <p class="ag-readonly-form-text">{{ $office->billing_city }}</p>
                    </div>

                    <div class="uk-margin-bottom">
                        <p class="uk-form-label">Land</p>
                        <p class="ag-readonly-form-text">{{ $office->billing_country }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection