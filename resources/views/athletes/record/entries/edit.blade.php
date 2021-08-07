@extends('layouts.main')

@section('title', trans('messages.athletes.record.entry.edit'))

@section('breadcrumb-link', action('App\Http\Controllers\HealthRecordEntryController@show', [ $athleteId, $entry->id ]))
@section('breadcrumb-title', 'Eintrag')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-2">
            <h1>{{ trans('messages.athletes.record.entry.edit') }}</h1>

            <div class="uk-card uk-card-small uk-card-default uk-card-body">

                <form class="uk-form-stacked" method="POST" action="{{ action('App\Http\Controllers\HealthRecordEntryController@update', [ $athleteId, $entry->id ]) }}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="PATCH" />

                    <div class="ag-card-nav uk-margin-bottom">
                        <a href="{{ action('App\Http\Controllers\HealthRecordEntryController@show', [ $athleteId, $entry->id ]) }}" class="ag-icon-fab" title="Zurück">
                            <i class="material-icons">close</i>
                        </a>

                        <button type="submit" class="ag-icon-fab uk-float-right" title="Speichern">
                            <i class="material-icons">check</i>
                        </button>
                    </div>

                    @include('athletes.record.entries.partials.form')
                </form>
            </div>
        </div>
    </div>
@endsection
