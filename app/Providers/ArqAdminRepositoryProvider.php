<?php

namespace ArqAdmin\Providers;

use Illuminate\Support\ServiceProvider;

class ArqAdminRepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \ArqAdmin\Repositories\FundoRepository::class,
            \ArqAdmin\Repositories\FundoRepositoryEloquent::class
        );

        $this->app->bind(
            \ArqAdmin\Repositories\SubfundoRepository::class,
            \ArqAdmin\Repositories\SubfundoRepositoryEloquent::class
        );

        $this->app->bind(
            \ArqAdmin\Repositories\GrupoRepository::class,
            \ArqAdmin\Repositories\GrupoRepositoryEloquent::class
        );

    }
}