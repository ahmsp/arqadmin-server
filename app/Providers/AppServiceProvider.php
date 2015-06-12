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
            'ArqAdmin\Models\Repositories\DocumentoRepositoryInterface',
            'ArqAdmin\Models\Repositories\DocumentoRepository'
        );
    }
}
