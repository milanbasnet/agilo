@extends('layouts.main')

@section('title', trans('messages.workout.templates'))

@section('breadcrumb-link', action('App\Http\Controllers\DashboardController@index'))
@section('breadcrumb-title', 'Dashboard')

@section('content')
     <div uk-grid>
        <div class="uk-width-1-2">
            <h1>{{ trans('messages.workout.templates') }}</h1>

            <div class="uk-margin-bottom" uk-grid>
                <div>
                    <a href="{{ action('App\Http\Controllers\WorkoutsController@create') }}" class="ag-icon-fab" title="Neu">
                        <i class="material-icons">add</i>
                    </a>
                </div>

                <div class="uk-width-expand">
                    <form class="uk-search uk-search-default uk-width-middle ag-search-accent uk-margin-bottom">
                        <div>
                            <a href="#" class="uk-search-icon-flip" uk-search-icon></a>
                            <input class="uk-search-input ag-js-filter-table" type="search" placeholder="Suche...">
                        </div>
                    </form>
                    <div class="ag-js-filter-label-wrapper uk-margin-bottom" data-ag-filter-for="ag-regions">
                        <h3 class="ag-filter-label-headline">Regionen</h3>
                        @foreach(\App\Models\RegionTag::all() as $region)
                            <span class="uk-label ag-js-filter-label" data-ag-filter-id="{{ $region->id }}">{{ $region->name }}</span>
                        @endforeach
                    </div>
                    <div class="ag-js-filter-label-wrapper uk-margin-bottom" data-ag-filter-for="ag-types">
                        <h3 class="ag-filter-label-headline">Art</h3>
                        @foreach(\App\Models\TypeTag::all() as $type)
                            <span class="uk-label ag-js-filter-label" data-ag-filter-id="{{ $type->id }}">{{ $type->name }}</span>
                        @endforeach
                    </div>
                    <div class="ag-js-filter-label-wrapper uk-margin-bottom" data-ag-filter-for="ag-level">
                        <h3 class="ag-filter-label-headline">Level</h3>
                        @foreach(\App\Models\LevelTag::all() as $level)
                            <span class="uk-label ag-js-filter-label" data-ag-filter-id="{{ $level->id }}">{{ $level->name }}</span>
                        @endforeach
                    </div>
                    <div class="ag-js-filter-label-wrapper uk-margin-bottom" data-ag-filter-for="ag-equipment">
                        <h3 class="ag-filter-label-headline">Material</h3>
                        @foreach(\App\Models\Equipment::all() as $equipment)
                            <span class="uk-label ag-js-filter-label" data-ag-filter-id="{{ $equipment->id }}">{{ $equipment->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="uk-card uk-card-default uk-card-body uk-padding-remove">
                <table class="uk-table uk-table-divider uk-table-middle">
                    <thead>
                    <tr>
                        <th colspan="2">Übungen</th>
                        <th class="uk-table-shrink"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($workouts as $workout)
                        <tr data-ag-regions="{{ $workout->regionIdsAsJson() }}"
                            data-ag-types="{{ $workout->typeIdsAsJson() }}"
                            data-ag-level="{{ $workout->levelIdAsJson() }}"
                            data-ag-equipment="{{ $workout->equipmentIdAsJson() }}">
                            <td><img class="ag-image-border ag-thumbnail" src="{{ asset('/storage/'.$workout->image_path) }}" alt="{{ $workout->translations->first()->title }}"/></td>
                            <td>{{ $workout->translations->first()->title }}</td>
                            <td>
                                <a href="{{ action('App\Http\Controllers\WorkoutsController@show', [ $workout->id ]) }}">
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
