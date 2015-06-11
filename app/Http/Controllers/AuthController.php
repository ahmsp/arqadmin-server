<?php

namespace ArqAdmin\Http\Controllers;

use Illuminate\Http\Request;

use ArqAdmin\Http\Requests;
//use ArqAdmin\Http\Controllers\Controller;
use Auth;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password', 'remember');

//dd($credentials);
        if (Auth::check() ) {
            return response('Usuário já autenticado', 400);
        }

        if(Auth::validate($credentials)) {

            $remember = ($credentials['remember']) ?: 'false';

            if (Auth::Attempt($credentials, $remember)) {
                return "usuário" . Auth::user()->name;
            }
        }

        // else check ldap

        return 'credenciais não válidas';
    }

    public function logout()
    {
        Auth::logout();
    }
}
