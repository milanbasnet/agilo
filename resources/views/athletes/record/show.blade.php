@extends('layouts.main')

@section('title', trans('messages.athletes.record'))

@section('breadcrumb-link', action('App\Http\Controllers\AthletesController@show', [ $athleteId ]))
@section('breadcrumb-title', 'Sportler')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-1">
            <h1>{{ trans('messages.athletes.record') }}</h1>
        </div>
        <div class="uk-width-1-2">
            <div class="uk-card uk-card-default">
                <div class="uk-card-header">
                    <h3 class="uk-card-title">Performance-Index</h3>
                </div>
                <div class="uk-card-body">
                    <canvas id="performance-index-chart"></canvas>
                </div>
            </div>
        </div>
        <div class="uk-width-1-2">
            <div class="uk-margin-bottom" uk-grid>
                <div>
                    <a href="{{ action('App\Http\Controllers\HealthRecordEntryController@create', [ $athleteId ]) }}" class="ag-icon-fab" title="Neu">
                        <i class="material-icons">add</i>
                    </a>
                </div>
            </div>

            <div class="uk-card uk-card-default ag-article-list">
                <div class="uk-card-header">
                    <h3 class="uk-card-title">Einträge</h3>
                </div>
                <div class="uk-card-body">
                    @foreach($healthRecord->entries as $entry)
                        <article class="uk-article">
                            <div uk-grid>
                                <h1 class="uk-width-expand uk-article-title">{{ $entry->title }}</h1>
                                <p class="uk-article-meta">{{ $entry->updated_at->format('d.m.Y') }}</p>
                            </div>
                            <div class="uk-margin-remove-top" uk-grid>
                                <p class="uk-width-expand ag-article-text">{{ Str::limit($entry->content, 200, '...') }}</p>
                                <p class="uk-flex uk-flex-bottom">
                                    <a class="uk-article-meta" href="{{ action('App\Http\Controllers\HealthRecordEntryController@show', [ $athleteId, $entry->id ]) }}">
                                        <i class="material-icons ag-inherit-line-height ag-color-accent">chevron_right</i>
                                    </a>
                                </p>
                            </div>
                        </article>

                        @if($healthRecord->entries->last() != $entry)
                            <hr>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ env('SUB_DIR', '') }}/js/Chart.bundle.min.js"></script>
    <script>
        var ctx = document.getElementById("performance-index-chart");
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["10.04.", "11.04.", "12.04.", "13.04.", "14.04.", "15.04."],
                datasets: [{
                    label: 'Absolvierte Übungen',
                    data: [3, 5, 8, 4, 3, 6],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true,
                            max: 10
                        }
                    }]
                }
            }
        });
    </script>
@endsection