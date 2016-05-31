<?php

namespace ArqAdmin\Policies;

use ArqAdmin\Entities\User;

class LcAcondicionamentoPolicy
{
    public function edit(User $user)
    {
        $allowedRoles = [
            'ROLE_DOCUMENTAL',
            'ROLE_SEPULTAMENTO'
        ];

        $userRoles = explode(',', $user->roles);

        return count(array_intersect($userRoles, $allowedRoles)) > 0 ? true : false;
    }
}
