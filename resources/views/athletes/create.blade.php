@extends('layouts.main')

@section('title', trans('messages.athletes.create'))

@section('breadcrumb-link', action('App\Http\Controllers\AthletesGroupsOverviewController@index'))
@section('breadcrumb-title', 'Sportler & Gruppen')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-2">
            <h1>{{ trans('messages.athletes.create') }}</h1>

            <div class="uk-card uk-card-small uk-card-default uk-card-body">

                <form class="uk-form-stacked" method="POST" action="{{ action('App\Http\Controllers\AthletesController@store') }}">
                    {!! csrf_field() !!}

                    @include('athletes.partials.athlete-form')
                </form>

            </div>
        </div>
    </div>
@endsection
