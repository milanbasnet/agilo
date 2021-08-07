<?php

namespace App\Providers;

use Auth;
use Caffeinated\Menus\Builder;
use Menu;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap menu service provider.
     */
    public function boot()
    {
        // TODO: refactor -> filter menu items by roles. maybe move to a middleware

        Menu::make('agilo_admin', function (Builder $menu) {
            $menu->add(trans('messages.offices'), array('action' => 'App\Http\Controllers\OfficesController@index'))->active('offices/*');
            $menu->add(trans('messages.workouts'), array('action' => 'App\Http\Controllers\WorkoutsController@index'))->active('workouts/*');
            $menu->add(trans('messages.routines'), array('action' => 'App\Http\Controllers\RoutinesController@index'))->active('routines/*');
        });

        Menu::make('agilo_user', function (Builder $menu) {
            $menu->add(trans('messages.office'), array('action' => 'App\Http\Controllers\UserOfficeController@show'))->active('office/*');
            $item = $menu->add(trans('messages.athletesgroupsoverview'), array('action' => 'App\Http\Controllers\AthletesGroupsOverviewController@index'));

            $item->active('athletes-groups/*');

            if (!$item->isActive()) {
                $item->active('athletes/*');
            }

            if (!$item->isActive()) {
                $item->active('groups/*');
            }

            $menu->add(trans('messages.routines'), array('action' => 'App\Http\Controllers\RoutinesController@index'))->active('routines/*');
        });

        Menu::make('agilo_office_admin', function (Builder $menu) {
            $menu->add(trans('messages.therapists'), array('action' => 'App\Http\Controllers\TherapistsController@index'))->active('therapists/*');
        });

        Menu::make('agilo_logout', function (Builder $menu) {
            $menu->add(trans('messages.logout'), array('action' => 'App\Http\Controllers\Auth\LoginController@logout'));
        });
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        // TODO: Implement register() method.
    }
}
