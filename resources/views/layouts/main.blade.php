<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agilo - @yield('title')</title>
    <link rel="stylesheet" href="{{ env('SUB_DIR', '') }}{{ url('css/app.css') }}"/>
    <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>
<body>
@include('menu.navbar')

<main class="uk-section uk-section-small">
    <div class="ag-js-viewport-expand uk-container">
        @if (count($errors) > 0)
            <div class="uk-card uk-card-small uk-card-default uk-card-body uk-margin-bottom uk-alert-danger">
                <p><strong>Folgende Fehler sind aufgetreten</strong></p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(Auth::user())
            <div uk-grid>
                <div class="uk-width-1-2">
                    @if(!isset($hideBreadcrumb))
                        <a href="@yield('breadcrumb-link')" class="ag-link ag-link--heading-color" title="@yield('breadcrumb-title')">
                            <i class="material-icons">chevron_left</i><span class="ag-icon-text">@yield('breadcrumb-title')</span>
                        </a>
                    @endif
                </div>
                <div class="uk-width-1-2">
                    <a href="{{ action('App\Http\Controllers\ProfileController@show') }}" class="uk-float-right ag-link ag-link--heading-color" title="Zum Profil">
                        <i class="material-icons">person</i><span class="ag-icon-text">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span>
                    </a>
                </div>
            </div>
        @endif
        @yield('content')
    </div>
</main>

    <script src="{{ env('SUB_DIR', '') }}{{ url('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>