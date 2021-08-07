@extends('layouts.main')
@section('title', 'Reset Password')

@section('content')

@if(isset($success))
<span style="color:green; font-size:20px">{{$success}}<span>
@endif
    <div uk-grid>
        <div class="uk-width-1-2@s uk-width-1-3@m">
            <div class="uk-card uk-card-small uk-card-default uk-card-body">

                <form class="uk-form-stacked" method="POST" action="{{route('user-password.update',$user->email)}}">
                    {!! csrf_field() !!}
                    @METHOD('PUT')
                    <div class="uk-margin-bottom">
                        <label class="uk-form-label" for="email">E-Mail-Adresse</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="email" name="email" type="text"  value="{{$user->email }}" readonly>
                        </div>
                    </div>

                    <div class="uk-margin-bottom">
                        <label class="uk-form-label" for="email">Code</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="code" name="code" type="text"  value="{{old('code')}}" >
                        </div>
                    </div>

                    <div class="uk-margin-bottom">
                        <label class="uk-form-label" for="email">Passwort</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="password" name="password" type="password"  value="{{old('password')}}" >
                        </div>
                    </div>

                    <div class="uk-margin-bottom">
                        <label class="uk-form-label" for="email">@lang('messages.confirm-password')</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="password_confirmation" name="password_confirmation" type="password"  value="{{old('password_confirmation')}}" >
                        </div>
                    </div>





                    <button type="submit" class="uk-button uk-button-default">@lang('messages.reset-password')</button>

                </form>

            </div>
        </div>
    </div>
@endsection
