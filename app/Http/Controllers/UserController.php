<?php

namespace ArqAdmin\Http\Controllers;

use ArqAdmin\Http\Requests;
use ArqAdmin\Entities\User;
use ArqAdmin\Repositories\UserRepository;
use ArqAdmin\Services\UserService;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use Illuminate\Http\Request;
use Stevebauman\Corp\Facades\Corp;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var UserService
     */
    protected $service;

    /**
     * @param UserRepository $repository
     * @param UserService $service
     */
    public function __construct(UserRepository $repository, UserService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Create a new user instance.
     *
     * @param Request $request
     * @return User
     */
//    protected function create(Request $request)
//    {
//        return User::create([
//            'name' => $request->input('name'),
//            'username' => $request->input('username'),
//            'email' => $request->input('email'),
//            'password' => bcrypt($request->input('password')),
//            'roles' => $request->input('roles'),
//        ]);
//    }

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        $data = $this->repository->paginate(500);
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return array
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $roles = json_decode($data['roles']);

        if (is_array($roles)) {
            $data['roles'] = implode(',', $roles);
        }

        return $this->service->create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return array
     */
    public function show($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return array
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $roles = json_decode($data['roles']);

        if (is_array($roles)) {
            $data['roles'] = implode(',', $roles);
        }

        return $this->service->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return array
     */
    public function destroy($id)
    {
        return $this->service->delete($id);
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

        return [
            'name' => $user->name,
            'username' => $user->username,
            'roles' => array_filter(explode(',', $user->roles)),
        ];
    }

}
