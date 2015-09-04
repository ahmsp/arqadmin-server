<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\LcMovelRepository;
use ArqAdmin\Entities\LcMovel;

/**
 * Class LcMovelRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class LcMovelRepositoryEloquent extends BaseRepository implements LcMovelRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LcMovel::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
