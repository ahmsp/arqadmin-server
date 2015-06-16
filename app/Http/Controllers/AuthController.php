<?php

namespace ArqAdmin\Http\Controllers;

use ArqAdmin\Http\Controllers\Controller;
use ArqAdmin\Models\User;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use ArqAdmin\Http\Requests;


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

        if ('ldap' === $request->input('login_type')) {

            $this->ldapLogin($request);
        }

        $credentials = $request->only('username', 'password');

        if($this->auth->validate($credentials)) {

            $remember = ($request->input('remember')) ?: 'false';

            if ($this->auth->attempt($credentials, $remember)) {
                return "usuário" . $request->user()->name;
            }
        }

        // check ldap

        return 'credenciais não válidas';
    }

    public function appLogin()
    {

    }

    public function ldapLogin(Request $request)
    {
        $user = User::where('username', $request->input('username'))->first();
        if ($user) {
            dd($user);
        }
    }

    public function logout()
    {
        $this->auth->logout();
    }
}
