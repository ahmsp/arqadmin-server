<?php

namespace ArqAdmin\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use ArqAdmin\Entities\Documento;
use ArqAdmin\Entities\Fotografia;
use ArqAdmin\Entities\RegistroSepultamento;

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
//        Relation::morphMap([
//            'documental' => Documento::class,
//            'fotografico' => Fotografia::class,
//            'sepultamento' => RegistroSepultamento::class,
//        ]);
    }
}
