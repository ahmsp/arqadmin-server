<?php

namespace ArqAdmin\Policies;

use ArqAdmin\Entities\User;

class UserPolicy
{
    public function editGuest(User $user)
    {
        $allowedRoles = [
            'ROLE_ADMIN',
            'ROLE_DOCUMENTAL',
            'ROLE_FOTOGRAFICO',
            'ROLE_SEPULTAMENTO',
            'ROLE_ATENDIMENTO',
        ];

        return count(array_intersect($user->roles, $allowedRoles)) > 0 ? true : false;
    }

    public function editUser(User $user)
    {
        $allowedRoles = [
            'ROLE_ADMIN',
        ];

        return count(array_intersect($user->roles, $allowedRoles)) > 0 ? true : false;
    }

    public function getResourceOwnerUser($user)
    {
        return $user == auth()->user();
    }
}
