<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\DossieRepository;
use ArqAdmin\Entities\Dossie;

/**
 * Class DossieRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class DossieRepositoryEloquent extends BaseRepository implements DossieRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Dossie::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
