<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\SubfundoRepository;
use ArqAdmin\Entities\Subfundo;

/**
 * Class SubfundoRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class SubfundoRepositoryEloquent extends BaseRepository implements SubfundoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Subfundo::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
