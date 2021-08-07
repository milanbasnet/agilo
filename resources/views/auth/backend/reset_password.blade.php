@extends('layouts.main')
@section('title', 'Reset Password')

@section('content')

    <div uk-grid>
        <div class="uk-width-1-2@s uk-width-1-3@m">
            <div class="uk-card uk-card-small uk-card-default uk-card-body">
                @if(Session::has('error'))
                <p style="color: red"> {{Session::get('error')}} </p>
                @endif
                <form class="uk-form-stacked" method="POST" action="{{route('user-password.store')}}">
                    {!! csrf_field() !!}
                    <div class="uk-margin-bottom">
                        <label class="uk-form-label" for="email">E-Mail-Adresse</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="email" name="email" type="email"  value="{{ old('email') }}">
                        </div>
                    </div>





                    <button type="submit" class="uk-button uk-button-default">{{trans('messages.send-reset-code')}}</button>

                </form>

            </div>
        </div>
    </div>
@endsection
