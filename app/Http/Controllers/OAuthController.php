<?php

namespace ArqAdmin\Http\Controllers;


use ArqAdmin\Models\User;
use Illuminate\Support\Facades\Auth;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use Stevebauman\Corp\Facades\Corp;

class OAuthController extends Controller
{
    public function accessToken()
    {
        return Authorizer::issueAccessToken();
    }

    public function verify($username, $password)
    {
        $credentials = [
            'username' => $username,
            'password' => $password,
        ];

        if (null === $user = User::where('username', $credentials['username'])->first()) {
            return false;
        }

        if (Auth::once($credentials)) {
            return Auth::user()->id;
        }

        // adldap auth
        if (Corp::auth($credentials['username'], $credentials['password'])) {

            $user->password = bcrypt($credentials['password']);
            $user->save();

            if (Auth::once($credentials)) {
                return Auth::user()->id;
            }
        }

        return false;
    }
}
