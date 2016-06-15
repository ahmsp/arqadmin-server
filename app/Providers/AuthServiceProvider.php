<?php

namespace ArqAdmin\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'ArqAdmin\Entities\User' => 'ArqAdmin\Policies\UserPolicy',
        'ArqAdmin\Entities\Especiedocumental' => 'ArqAdmin\Policies\EspeciedocumentalPolicy',
        'ArqAdmin\Entities\LcAcondicionamento' => 'ArqAdmin\Policies\LcAcondicionamentoPolicy',
        'ArqAdmin\Entities\LcCompartimento' => 'ArqAdmin\Policies\LcCompartimentoPolicy',
        'ArqAdmin\Entities\LcMovel' => 'ArqAdmin\Policies\LcMovelPolicy',
        'ArqAdmin\Entities\LcSala' => 'ArqAdmin\Policies\LcSalaPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('role-documental', function ($user) {
            return $this->hasRole($user, 'ROLE_DOCUMENTAL');
        });

        $gate->define('role-fotografico', function ($user) {
            return $this->hasRole($user, 'ROLE_FOTOGRAFICO');
        });

        $gate->define('role-sepultamento', function ($user) {
            return $this->hasRole($user, 'ROLE_SEPULTAMENTO');
        });

        $gate->define('role-atendimento', function ($user) {
            return $this->hasRole($user, 'ROLE_ATENDIMENTO');
        });

        $gate->before(function ($user, $ability) {
            if ($this->hasRole($user, 'ROLE_ADMIN')) {
                return true;
            }
        });
    }

    public function hasRole($user, $role)
    {
        return in_array($role, $user->roles);
    }
}
