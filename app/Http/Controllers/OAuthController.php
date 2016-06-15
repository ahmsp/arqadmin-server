<?php

namespace ArqAdmin\Http\Controllers;


use ArqAdmin\Entities\User;
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

            if ($adldapUser = $this->adldapAuth($credentials['username'], $credentials['password'])) {

                $user = new User();
                $user->name = $adldapUser['name'];
                $user->username = $adldapUser['username'];
                $user->email = $adldapUser['email'];
                $user->adldap_group = $adldapUser['group'];
                $user->adldap_type = $adldapUser['type'];
                $user->password = $credentials['password'];
                $user->roles = [];

                $user->save();

                if (Auth::once($credentials)) {
                    return Auth::user()->id;
                }
            }

            return false;
        }

        if (Auth::once($credentials)) {
            return Auth::user()->id;
        }

        if ($this->adldapAuth($credentials['username'], $credentials['password'])) {

            $user->password = $credentials['password'];
            $user->save();

            if (Auth::once($credentials)) {
                return Auth::user()->id;
            }
        }

        return false;
    }

    private function adldapAuth($username, $password)
    {
        if (Corp::auth($username, $password)) {

            $userInfo = Corp::user($username);

            return [
                'username' => $userInfo->username,
                'name' => $userInfo->name,
                'email' => $userInfo->email,
                'group' => $userInfo->group,
                'type' => $userInfo->type,
            ];
        }

        return false;
    }

    public function getResourceOwner()
    {
        return Authorizer::getResourceOwnerId();
    }
}
