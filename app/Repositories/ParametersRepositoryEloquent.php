<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\ParametersRepository;
use ArqAdmin\Entities\Parameters;

/**
 * Class ParametersRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class ParametersRepositoryEloquent extends BaseRepository implements ParametersRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Parameters::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
