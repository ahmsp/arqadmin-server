<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\UserRepository;
use ArqAdmin\Validators\UserValidator;
use Illuminate\Http\Request;

class UserService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return UserRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return UserValidator::class;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function createGuest(Request $request)
    {
        $randomAccessCode = rand(pow(10, 6 - 1), pow(10, 6) - 1); // random 6 digits

        $data = [
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => $randomAccessCode,
            'adldap_type' => 'Consulente AHSP',
            'roles' => [],
        ];

        $user = $this->create($data);
        $user['access_code'] = $randomAccessCode;

        return $user;
    }

    public function refreshGuestAccessCode($id)
    {
        $user = $this->repository->find($id);
        if (!($user->username{0} == 'c' && count($user->roles) === 0)) {
            abort(401, 'O usuário não é um consulente.');
        }
            
        $randomAccessCode = rand(pow(10, 6 - 1), pow(10, 6) - 1); // random 6 digits

        $user = $this->repository->update(['password' => $randomAccessCode], $id);
        $user['access_code'] = $randomAccessCode;

        return $user;
    }
}
