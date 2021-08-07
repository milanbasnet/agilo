@extends('layouts.main')

@section('title', trans('messages.routines.workouts.overview'))

@section('breadcrumb-link', action('App\Http\Controllers\RoutinesController@show', [ $routine->id ]))
@section('breadcrumb-title', 'Übungsplan')

@section('content')
    <div uk-grid>
        <div class="uk-width-1-1">
            <h1>{{ trans('messages.routines.workouts.overview') }}</h1>
        </div>
        <div class="uk-width-1-1">
            <div uk-grid>
                <div class="uk-width-1-2">
                </div>
                <div class="uk-width-1-2">
                    <form class="uk-search uk-search-default uk-width-middle ag-search-accent uk-margin-bottom">
                        <a href="#" class="uk-search-icon-flip" uk-search-icon></a>
                        <input class="uk-search-input ag-js-filter-table" type="search" placeholder="Suche...">
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
        </div>
        <div class="uk-width-1-2">
            <div class="uk-card uk-card-default uk-card-body uk-padding-remove">
                <table class="uk-table uk-table-divider uk-table-middle">
                    <thead>
                    <tr>
                        <th colspan="2">Zugewiesene Übungen 
                            <div class="uk-width-auto uk-flex" style="float: right">
                                <button id="submitAllButton" type="submit" class="ag-icon-fab uk-margin-auto" title="Update values">
                                    <i class="material-icons ag-inherit-line-height">autorenew</i>
                                </button>
                            </div>
                        </th>
                    </tr>
                    
                    </thead>
                    <tbody>
                    @foreach($routine->parameterizedWorkouts as $paramWorkout)
                        <tr>
                            <td class="ag-line-height-1 uk-table-shrink">
                                <form class="uk-form-stacked" method="POST" action="{{ action('App\Http\Controllers\RoutinesController@unassign', [ $routine->id ]) }}">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="_method" value="PATCH" />
                                    <input type="hidden" name="paramWorkout" value="{{ $paramWorkout->id }}" />

                                    <button type="submit" class="ag-icon-fab">
                                        <i class="material-icons ag-inherit-line-height">close</i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form class="uk-form-stacked formWorkout-class" method="POST" action="{{ action('App\Http\Controllers\RoutinesController@update_assigned_workout', [ $routine->id ]) }}">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="_method" value="PATCH" />
                                    <input type="hidden" name="paramWorkout" value="{{ $paramWorkout->id }}" />

                                    <div uk-grid>
                                        <div class="uk-width-expand">
                                            <div uk-grid='{"margin": "uk-margin-small-top"}'>
                                                <div class="uk-width-1-1">
                                                    {{ $paramWorkout->workout->translations->first()->title }}
                                                </div>
                                                <div class="uk-width-1-3">
                                                    <label class="uk-form-label" for="sets">Sätze</label>
                                                    <div class="uk-form-controls">
                                                        <input class="uk-input" id="sets" type="number" min="0" max="50" name="sets" value="{{ $paramWorkout->sets }}">
                                                    </div>
                                                </div>
                                                <div class="uk-width-1-3">
                                                   @if($paramWorkout->workout->type == 1)
                                                        <label class="uk-form-label" for="repetitions">Wdh.</label>
                                                        <div class="uk-form-controls">
                                                            <input class="uk-input" id="repetitions" type="number" min="0" max="50" name="repetitions" value="{{ $paramWorkout->repetitions }}">
                                                        </div>
                                                    @elseif($paramWorkout->workout->type == 2)
                                                        <label class="uk-form-label" for="holding_period">Haltezeit</label>
                                                        <div class="uk-form-controls">
                                                            <input class="uk-input" id="holding_period" type="number" min="0" max="300" name="holding_period" value="{{ $paramWorkout->holding_period }}">
                                                        </div>
                                                    @endif

                                                </div>
                                                <div class="uk-width-1-3">
                                                    <label class="uk-form-label" for="rest">Sek. Pause</label>
                                                    <div class="uk-form-controls">
                                                        <input class="uk-input" id="rest" type="number" min="0" max="600" name="rest" value="{{ $paramWorkout->rest }}">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="uk-width-auto uk-flex">
                                            <button type="submit" class="ag-icon-fab uk-margin-auto" title="Update values">
                                                <i class="material-icons ag-inherit-line-height">autorenew</i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            
                        
                           
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="uk-width-1-2">
            <div class="uk-card uk-card-default uk-card-body uk-padding-remove">
                <table class="uk-table uk-table-divider uk-table-middle">
                    <thead>
                    <tr>
                        <th colspan="3">Übungstemplates</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($workouts as $workout)
                        <tr data-ag-regions="{{ $workout->regionIdsAsJson() }}"
                            data-ag-types="{{ $workout->typeIdsAsJson() }}"
                            data-ag-level="{{ $workout->levelIdAsJson() }}"
                            data-ag-equipment="{{ $workout->equipmentIdAsJson() }}">
                            <td class="ag-line-height-1 uk-table-shrink">
                                <form class="uk-form-stacked" method="POST" action="{{ action('App\Http\Controllers\RoutinesController@assign', [ $routine->id ]) }}">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="_method" value="PATCH" />
                                    <input type="hidden" name="workout" value="{{ $workout->id }}" />

                                    <button type="submit" class="ag-icon-fab">
                                        <i class="material-icons ag-inherit-line-height">add</i>
                                    </button>
                                </form>
                            </td>
                            <td>{{ $workout->translations->first()->title }}</td>
                            <td class="uk-table-shrink">
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
    <script>
        const submitAll = (e) => {
            e.preventDefault();
            [...document.getElementsByClassName('formWorkout-class')].forEach(form => {
              var formData = new FormData(form);
              var request = new XMLHttpRequest();
              request.open("POST", form.action);
              request.send(formData);
              console.log(form.action + " submitted")
            });
          }
          
          document.getElementById("submitAllButton").addEventListener('click', submitAll, true)
          </script>
@endsection
