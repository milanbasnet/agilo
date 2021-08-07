<li {!! $item->isActive() ? 'class="uk-active"' : '' !!}>

    <a href="{{ $item->url() }}">{{ $item->title }}</a>
</li>