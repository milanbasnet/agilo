@extends('layouts.main')

@section('title', trans('messages.workouts.edit'))

@section('breadcrumb-link', action('App\Http\Controllers\WorkoutsController@show', [ $workout->id ]))
@section('breadcrumb-title', 'Übungstemplate')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-2">
            <h1>{{ trans('messages.workouts.edit') }}</h1>

            <div class="uk-card uk-card-small uk-card-default uk-card-body">

                <form class="uk-form-stacked" method="POST" action="{{ action('App\Http\Controllers\WorkoutsController@update', [ $workout->id ]) }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="PATCH" />

                    <div class="ag-card-nav uk-margin-bottom">
                        <a href="{{ action('App\Http\Controllers\WorkoutsController@show', [ $workout->id ]) }}" class="ag-icon-fab" title="Zurück">
                            <i class="material-icons">close</i>
                        </a>

                        <button type="submit" class="ag-icon-fab uk-float-right" title="{{ trans('messages.workouts.edit.submit.label') }}">
                            <i class="material-icons">check</i>
                        </button>
                    </div>

                    @include('workouts.partials.workout-form')
                </form>
            </div>
        </div>
    </div>
@endsection
