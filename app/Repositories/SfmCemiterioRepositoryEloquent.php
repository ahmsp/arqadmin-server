<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\SfmCemiterioRepository;
use ArqAdmin\Entities\SfmCemiterio;

/**
 * Class SfmCemiterioRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class SfmCemiterioRepositoryEloquent extends BaseRepository implements SfmCemiterioRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SfmCemiterio::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
