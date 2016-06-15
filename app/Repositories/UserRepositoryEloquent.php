<?php

namespace ArqAdmin\Repositories;

use ArqAdmin\Entities\User;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Contracts\ValidatorInterface;

/**
 * Class UserRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function findAllUsers()
    {
        return $this->paginate(500);
    }

    public function findAllGuests()
    {
        $model = $this->model
            ->where('username', 'like', 'c%')
            ->where(function ($query) {
                $query->where('roles', '=', '')
                    ->orWhereNull('roles');
            })
            ->paginate(500);

        return $model;
    }
}
