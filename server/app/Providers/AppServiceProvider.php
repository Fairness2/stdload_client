<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use App\Extensions\Helpers;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function ($query) {
            // $query->sql
            // $query->bindings
            // $query->time
            if (stripos($query->sql, 'log_query') === false && stripos($query->sql, 'log_route') === false)
                Helpers::loggingDB($query);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app['request']->server->set('HTTPS', true);
    }
}
