<?php

namespace ArqAdmin\Http\Controllers;

use ArqAdmin\Http\Requests;
use ArqAdmin\Entities\User;
use ArqAdmin\Repositories\UserRepository;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new user instance.
     *
     * @param Request $request
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
