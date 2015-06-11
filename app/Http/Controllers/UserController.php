<?php

namespace ArqAdmin\Http\Controllers;

use Illuminate\Http\Request;

use ArqAdmin\Http\Requests;
use ArqAdmin\Http\Controllers\Controller;
use ArqAdmin\Models\User;

class UserController extends Controller
{
    /**
     * Create a new user instance.
     *
     * @param  array $data
     * @return User
     */
    protected function create(Request $request)
    {
        return User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
    }
}
