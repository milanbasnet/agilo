<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use App\Models\VideoValidator;
use App\Models\Office;
use App\Models\AthleteGroupSport;
use App\Models\RegionTag;
use Illuminate\Support\Facades\Hash;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //

        $this->app->singleton(AssetService::class, function ($app) {
            return new AssetService();
        });

        $this->app->singleton(Mailer::class, function ($app) {
            return new Mailer();
        });

        $this->app->singleton(TagService::class, function ($app) {
            return new TagService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {


        Validator::extend('passwords_match', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, $parameters[0]);
        });

        $this->app->validator->resolver(function($translator, $data, $rules, $messages)
        {
            return new VideoValidator($translator, $data, $rules, $messages);
        });

        Validator::extend('therapists', function ($attribute, $value, $parameters, $validator) {
            $therapistIds = Office::therapists()->map(function ($item) {
                return $item->id;
            });

            $count = collect($value)->diff($therapistIds)->count();
            return $count < 1;
        });

        Validator::extend('sports', function ($attribute, $value, $parameters, $validator) {
            $sportIds = AthleteGroupSport::all()->map(function ($item) {
                return $item->id;
            });

            $count = collect($value)->diff($sportIds)->count();
            return $count < 1;
        });

        Validator::extend('regions', function ($attribute, $value, $parameters, $validator) {
            $regionIds = RegionTag::all()->map(function ($item) {
                return $item->id;
            });

            $count = collect($value)->diff($regionIds)->count();
            return $count < 1;
        });
        //
    }
}
