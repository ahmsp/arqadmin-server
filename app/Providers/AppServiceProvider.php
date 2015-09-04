<?php

namespace ArqAdmin\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'ArqAdmin\Repositories\Contracts\DocumentosRepositoryInterface',
            'ArqAdmin\Repositories\DocumentosRepositoryEloquent'
        );
    }
}
