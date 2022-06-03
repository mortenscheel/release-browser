<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
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
        Model::preventLazyLoading(app()->environment('local'));
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // if (class_exists(MeiliSearch::class)) {
        //     $client = app(Client::class);
        //     $config = config('scout.meilisearch.settings');
        //     collect($config)
        //         ->each(function ($settings, $class) use ($client) {
        //             $model = new $class;
        //             $index = $client->index($model->searchableAs());
        //             collect($settings)
        //                 ->each(function ($params, $method) use ($index) {
        //                     $index->{$method}($params);
        //                 });
        //             // Give higher ranking to sort
        //             $index->updateRankingRules([
        //                 'words',
        //                 'sort',
        //                 'typo',
        //                 'proximity',
        //                 'attribute',
        //                 'exactness',
        //             ]);
        //         });
        // }
    }
}
