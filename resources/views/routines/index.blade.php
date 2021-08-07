@extends('layouts.main')

@section('title', trans('messages.routines'))

@section('breadcrumb-link', action('App\Http\Controllers\DashboardController@index'))
@section('breadcrumb-title', 'Dashboard')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-2">
            <h1>{{ trans('messages.routines') }}</h1>

            <div class="uk-margin-bottom" uk-grid>
                <div>
                    <a href="{{ action('App\Http\Controllers\RoutinesController@create') }}" class="ag-icon-fab" title="Neu">
                        <i class="material-icons">add</i>
                    </a>
                </div>

                <div class="uk-width-expand">
                    <form class="uk-search uk-search-default uk-width-middle ag-search-accent uk-margin-bottom">
                        <a href="#" class="uk-search-icon-flip" uk-search-icon></a>
                        <input class="uk-search-input ag-js-filter-table" type="search" placeholder="Suche...">
                    </form>
                    <div class="ag-js-filter-label-wrapper uk-margin-bottom" data-ag-filter-for="ag-measure">
                        <h3 class="ag-filter-label-headline">Maßnahme</h3>
                        @foreach(\App\Models\MeasureTag::all() as $measure)
                            <span class="uk-label ag-js-filter-label" data-ag-filter-id="{{ $measure->id }}">{{ $measure->name }}</span>
                        @endforeach
                    </div>
                    <div class="ag-js-filter-label-wrapper uk-margin-bottom" data-ag-filter-for="ag-regions">
                        <h3 class="ag-filter-label-headline">Trainierte Region</h3>
                        @foreach(\App\Models\RegionTag::all() as $region)
                            <span class="uk-label ag-js-filter-label" data-ag-filter-id="{{ $region->id }}">{{ $region->name }}</span>
                        @endforeach
                    </div>
                    <div class="ag-js-filter-label-wrapper uk-margin-bottom" data-ag-filter-for="ag-objective">
                        <h3 class="ag-filter-label-headline">Trainingsziel</h3>
                        @foreach(\App\Models\ObjectiveTag::all() as $objective)
                            <span class="uk-label ag-js-filter-label" data-ag-filter-id="{{ $objective->id }}">{{ $objective->name }}</span>
                        @endforeach
                    </div>
                    <div class="ag-js-filter-label-wrapper uk-margin-bottom" data-ag-filter-for="ag-sport">
                        <h3 class="ag-filter-label-headline">Sportart</h3>
                        @foreach(\App\Models\AthleteGroupSport::all() as $sport)
                            <span class="uk-label ag-js-filter-label" data-ag-filter-id="{{ $sport->id }}">{{ trans($sport->i18n) }}</span>
                        @endforeach
                    </div>
                    <div class="ag-js-filter-label-wrapper uk-margin-bottom" data-ag-filter-for="ag-gender">
                        <h3 class="ag-filter-label-headline">Geschlecht</h3>
                        @foreach(\App\Models\GenderTag::all() as $gender)
                            <span class="uk-label ag-js-filter-label" data-ag-filter-id="{{ $gender->id }}">{{ $gender->name }}</span>
                        @endforeach
                    </div>
                    <div class="ag-js-filter-label-wrapper uk-margin-bottom" data-ag-filter-for="ag-age">
                        <h3 class="ag-filter-label-headline">Alter</h3>
                        @foreach(\App\Models\AgeTag::all() as $age)
                            <span class="uk-label ag-js-filter-label" data-ag-filter-id="{{ $age->id }}">{{ $age->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="uk-card uk-card-default uk-card-body uk-padding-remove">
                <table class="uk-table uk-table-divider uk-table-middle">
                    <thead>
                    <tr>
                        <th>Übungspläne</th>
                        <th class="uk-table-shrink"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($routines) < 1)
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                    @foreach($routines as $routine)
                        <tr data-ag-measure="{{ $routine->measureIdAsJson() }}"
                            data-ag-regions="{{ $routine->regionIdsAsJson() }}"
                            data-ag-objective="{{ $routine->objectiveIdAsJson() }}"
                            data-ag-sport="{{ $routine->sportIdAsJson() }}"
                            data-ag-gender="{{ $routine->genderIdAsJson() }}"
                            data-ag-age="{{ $routine->ageIdAsJson() }}">
                            <td>{{ $routine->translations->first()->title }}</td>
                            <td>
                                <a href="{{ action('App\Http\Controllers\RoutinesController@show', [ $routine->id ]) }}">
                                    <i class="material-icons ag-inherit-line-height ag-color-accent">chevron_right</i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
