<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Allows foreign keys in sqlite.
        if(config('database.default') == 'sqlite')
        {
            $db = app()->make('db');
            $db->connection()->getPdo()->exec("pragma foreign_keys=1");
        }
    }
}
