<?php

namespace ArqAdmin\Http\Controllers;

use ArqAdmin\Http\Controllers\Controller;
use ArqAdmin\Models\User;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use ArqAdmin\Http\Requests;
use Stevebauman\Corp\Facades\Corp;


class AuthController extends Controller
{
    private $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function login(Request $request)
    {
        if ($this->auth->check()) {
            return response('Usuário já autenticado', 400);
        }

        $credentials = $request->only('username', 'password');

        if (null === $user = User::where('username', $credentials['username'])->first()) {
            return response('Usuário não cadastrado', 400);
        }

        if ('app' === $request->input('login_type')) {

            if ($this->auth->attempt($credentials, $request->input('remember'))) {
                return response('Logado', 200);
            }

        } else {

            if (Corp::auth($credentials['username'], $credentials['password'])) {
                $this->auth->login($user, $request->input('remember'));
                return response('Logado', 200);
            }
        }

        return response('Credenciais inválidas', 400);
    }

    public function logout()
    {
        $this->auth->logout();
        return response('Logout', 200);
    }

}
