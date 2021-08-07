@extends('layouts.main')

@section('title', trans('messages.routines.create.header'))

@section('breadcrumb-link', action('App\Http\Controllers\RoutinesController@index'))
@section('breadcrumb-title', 'Übungspläne')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-2">
            <h1>{{ trans('messages.routines.create.header') }}</h1>

            <div class="uk-card uk-card-small uk-card-default uk-card-body">

                <form class="uk-form-stacked" method="POST" action="{{ action('App\Http\Controllers\RoutinesController@store') }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}

                    <div class="ag-card-nav uk-margin-bottom">
                        <a href="{{ action('App\Http\Controllers\RoutinesController@index') }}" class="ag-icon-fab" title="Zurück">
                            <i class="material-icons">close</i>
                        </a>

                        <button type="submit" class="ag-icon-fab uk-float-right" title="{{ trans('messages.routines.create.submit.label') }}">
                            <i class="material-icons">check</i>
                        </button>
                    </div>

                    @include('routines.partials.routine-form')
                </form>
            </div>
        </div>
    </div>
@endsection
