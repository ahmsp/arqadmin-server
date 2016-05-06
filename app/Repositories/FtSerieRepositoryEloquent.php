<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\FtSerieRepository;
use ArqAdmin\Entities\FtSerie;

/**
 * Class FtSerieRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class FtSerieRepositoryEloquent extends BaseRepository implements FtSerieRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FtSerie::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
