@extends('layouts.main')
@section('title', 'Reset Password')

@section('content')

@if(isset($success))
<span style="color:green; font-size:20px">{{$success}}<span>
@endif
    <div uk-grid>
        <div class="uk-width-1-2@s uk-width-1-3@m">
            <div class="uk-card uk-card-small uk-card-default uk-card-body">

           {{trans('messages.success-password-changed')}}
            </div>
        </div>
    </div>
@endsection