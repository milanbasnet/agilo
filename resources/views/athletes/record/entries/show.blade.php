@extends('layouts.main')

@section('title', trans('messages.athletes.record.entry'))

@section('breadcrumb-link', action('App\Http\Controllers\HealthRecordController@show', [ $athleteId ]))
@section('breadcrumb-title', 'Sportlerakte')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-2">
            <h1>{{ trans('messages.athletes.record.entry') }}</h1>

            <div class="uk-card uk-card-small uk-card-default uk-card-body">
                <div class="ag-card-nav uk-margin-bottom">
                    <a href="{{ action('App\Http\Controllers\HealthRecordController@show', [ $athleteId ]) }}" class="ag-icon-fab" title="Zurück">
                        <i class="material-icons">chevron_left</i>
                    </a>

                    @if($entry->user->id == Auth::user()->id)
                        <div class="uk-float-right">
                            <form class="uk-display-inline-block" method="POST" action="{{ action('App\Http\Controllers\HealthRecordEntryController@destroy', [ $athleteId, $entry->id ]) }}">
                                {!! csrf_field() !!}
                                <input type="hidden" name="_method" value="DELETE" />

                                <button type="submit" class="ag-icon-fab uk-float-left" title="Deaktivieren">
                                    <i class="material-icons">delete</i>
                                </button>
                            </form>

                            <a href="{{ action('App\Http\Controllers\HealthRecordEntryController@edit', [ $athleteId, $entry->id ]) }}" class="ag-icon-fab uk-margin-left" title="Neu">
                                <i class="material-icons">edit</i>
                            </a>
                        </div>
                    @endif
                </div>

                <article class="uk-article">
                    <p class="uk-article-meta">
                        {{ $entry->updated_at->format('d.m.Y') }}<br>{{ $entry->user->first_name }} {{ $entry->user->last_name }}
                    </p>
                    <h1 class="uk-article-title">{{ $entry->title }}</h1>


                    <p class="uk-text-lead">{!! nl2br(e($entry->content)) !!}</p>

                </article>
            </div>
        </div>
    </div>
@endsection