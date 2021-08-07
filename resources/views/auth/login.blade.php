@extends('layouts.main')

@section('title', 'Login')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-2@s uk-width-1-3@m">
            <div class="uk-card uk-card-small uk-card-default uk-card-body">

                <form class="uk-form-stacked" method="POST" action="{{route('login') }}">
                    {!! csrf_field() !!}

                    <div class="uk-margin-bottom">
                        <label class="uk-form-label" for="email">E-Mail-Adresse</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="email" name="email" type="email"  value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="password">Passwort</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="password" name="password" type="password">
                        </div>
                    </div>

                    <div class="uk-margin">
                        <div class="uk-form-controls">
                            <label for="remember"><input class="uk-checkbox" type="checkbox" id ="remember" name="remember"> Angemeldet bleiben</label>
                        </div>
                    </div>
                    <div class="uk-margin">
                            <label for="forgot_password"><a href="{{route('user-password.index')}}"> @lang('messages.forgot-password')<a></label>

                    </div>


                    <button type="submit" class="uk-button uk-button-default">Login</button>

                </form>

            </div>
        </div>
    </div>
@endsection
