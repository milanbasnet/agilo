<header class="uk-navbar-container">
    <div class="uk-container uk-container-expand">
        <nav class="uk-navbar" uk-navbar>
            <div class="uk-navbar-left">
                <a href="{{ action('App\Http\Controllers\DashboardController@index') }}" class="uk-navbar-item uk-logo">Agilo</a>
            </div>
            <div class="uk-navbar-center">
                <ul class="uk-navbar-nav">
                    @include('menu.partials.menu')
                </ul>
            </div>
            @if(Auth::check())
                <div class="uk-navbar-right">
                    <ul class="uk-navbar-nav ag-nav-logout">
                        @include('menu.partials.logout')
                    </ul>
                </div>
            @endif
        </nav>
    </div>
</header>