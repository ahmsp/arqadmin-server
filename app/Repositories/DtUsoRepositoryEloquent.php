<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\DtUsoRepository;
use ArqAdmin\Entities\DtUso;

/**
 * Class DtUsoRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class DtUsoRepositoryEloquent extends BaseRepository implements DtUsoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DtUso::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
