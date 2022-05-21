<?php

namespace App\Providers;

use App\Models\Release;
use Illuminate\Support\ServiceProvider;
use MeiliSearch\Client;
use MeiliSearch\MeiliSearch;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Release::updateMeiliConfig();
    }
}
