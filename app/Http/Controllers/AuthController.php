<?php

namespace ArqAdmin\Http\Controllers;

use ArqAdmin\Http\Controllers\Controller;
use ArqAdmin\Models\User;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use ArqAdmin\Http\Requests;
use Illuminate\Support\Facades\Hash;
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
            $this->auth->logout();
//            return ['success' => false, 'message' => 'Usuário já autenticado'];
        }

        $credentials = $request->only('username', 'password');

        if (null === $user = User::where('username', $credentials['username'])->first()) {
            return [
                'success' => false,
                'message' => 'Usuário não cadastrado'
            ];
        }

        // application auth
        if ($this->auth->attempt($credentials)) {
            return [
                'success' => true,
                'message' => 'Autenticado',
                'data'  => $this->auth->user(),
            ];
        }

        // adldap auth
        if (Corp::auth($credentials['username'], $credentials['password'])) {

            $this->auth->login($user);
            $user->password = Hash::make($credentials['password']);
            $user->save();

            return [
                'success' => true,
                'message' => 'Autenticado',
                'data'  => $this->auth->user(),
            ];
        }

        return [
            'success' => false,
            'message' => 'Credenciais inválidas'
        ];
    }

    public function logout()
    {
        $this->auth->logout();

        return [
            'success' => true,
            'message' => 'Sessão finalizada'
        ];
    }

}
