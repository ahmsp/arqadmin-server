<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\SubgrupoRepository;
use ArqAdmin\Entities\Subgrupo;

/**
 * Class SubgrupoRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class SubgrupoRepositoryEloquent extends BaseRepository implements SubgrupoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Subgrupo::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
