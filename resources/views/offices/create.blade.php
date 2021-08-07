@extends('layouts.main')

@section('title', trans('messages.offices.create'))

@section('breadcrumb-link', action('App\Http\Controllers\OfficesController@index'))
@section('breadcrumb-title', 'Mandanten')

@section('content')
    @include('offices.partials.office-form')
@endsection
