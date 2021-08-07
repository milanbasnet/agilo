@extends('layouts.main')

@section('title', trans('messages.workouts.create'))

@section('breadcrumb-link', action('App\Http\Controllers\WorkoutsController@index'))
@section('breadcrumb-title', 'Übungstemplates')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-2">
            <h1>{{ trans('messages.workouts.create') }}</h1>

            <div class="uk-card uk-card-small uk-card-default uk-card-body">

                <form class="uk-form-stacked" method="POST" action="{{ action('App\Http\Controllers\WorkoutsController@store') }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}

                    <div class="ag-card-nav uk-margin-bottom">
                        <a href="{{ action('App\Http\Controllers\WorkoutsController@index') }}" class="ag-icon-fab" title="Zurück">
                            <i class="material-icons">close</i>
                        </a>

                        <button type="submit" class="ag-icon-fab uk-float-right" title="{{ trans('messages.workouts.create.submit.label') }}">
                            <i class="material-icons">check</i>
                        </button>
                    </div>

                    @include('workouts.partials.workout-form')
                </form>
            </div>
        </div>
    </div>
@endsection
