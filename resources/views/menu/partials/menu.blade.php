@if(Auth::check())
    @if(Auth::user()->isAdmin())
        @foreach($menu_agilo_admin->roots()  as $item)
            @include('menu.partials.item')
        @endforeach
    @else
        @foreach($menu_agilo_user->roots() as $item)
            @include('menu.partials.item')
        @endforeach
    @endif

    @if(Auth::user()->isOfficeAdmin())
        @foreach($menu_agilo_office_admin->roots() as $item)
            @include('menu.partials.item')
        @endforeach
    @endif
@endif