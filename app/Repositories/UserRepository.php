<?php

namespace ArqAdmin\Models\Repositories;


use ArqAdmin\Models\User;

class UserRepository
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function find($id)
    {
        $this->user->find($id);
    }

    public function findAll()
    {
        // TODO: Implement findAll() method.
    }

    public function add()
    {
        // TODO: Implement add() method.
    }

    public function update($id)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

}