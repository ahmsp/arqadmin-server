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
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        if ($request->input('userType') === 'users') {
            if (auth()->user()->can('editUser', User::class)) {
                return $this->repository->findAllUsers();
            }
        }

        $this->authorize('editGuest', User::class);

        return $this->repository->findAllGuests();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return array
     */
    public function store(Request $request)
    {
        $this->authorize('editGuest', User::class);

        return $this->service->createGuest($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return array
     */
    public function show($id)
    {
        $this->authorize('editUser', User::class);
        
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
        if (auth()->user()->can('editUser', User::class)) {
            return $this->service->update($request->all(), $id);
        }
        
        $this->authorize('editGuest', User::class);

        return $this->service->update(array_filter($request->only('name', 'email')), $id);
    }

    public function refreshGuestAccessCode($id)
    {
        $this->authorize('editGuest', User::class);

        return $this->service->refreshGuestAccessCode($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return array
     */
    public function destroy($id)
    {
        $this->authorize('editUser', User::class);

        return $this->service->delete($id);
    }

    public function getResourceOwnerUser()
    {
        $userId = Authorizer::getResourceOwnerId();
        $user = User::find($userId);

        return [
            'name' => $user->name,
            'username' => $user->username,
            'roles' => $user->roles,
        ];
    }

    public function getRevisionHistory($id)
    {
        $this->authorize('role-admin');

        return $this->service->getRevisionHistory($id);
    }

    public function getAllRevisionHistory()
    {
        $this->authorize('role-admin');

        return $this->service->getAllRevisionHistory();
    }
}
