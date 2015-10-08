<?php

namespace ArqAdmin\Http\Controllers;

use Illuminate\Http\Request;

use ArqAdmin\Http\Requests;
use ArqAdmin\Http\Controllers\Controller;
use ArqAdmin\Models\User;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

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

    /**
     * Update the password for the user.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate the new password length...

        $user->fill([
            'password' => Hash::make($request->newPassword)
        ])->save();
    }

    public function getResourceOwnerUser()
    {
        $userId = Authorizer::getResourceOwnerId();
        $user = User::find($userId);

        return $user;
    }
}
