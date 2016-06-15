<?php

namespace ArqAdmin\Policies;

use ArqAdmin\Entities\User;

class LcMovelPolicy
{
    public function edit(User $user)
    {
        $allowedRoles = [
            'ROLE_DOCUMENTAL',
            'ROLE_SEPULTAMENTO'
        ];

        return count(array_intersect($user->roles, $allowedRoles)) > 0 ? true : false;
    }
}
