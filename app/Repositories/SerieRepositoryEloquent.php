<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\SerieRepository;
use ArqAdmin\Entities\Serie;

/**
 * Class SerieRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class SerieRepositoryEloquent extends BaseRepository implements SerieRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Serie::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
