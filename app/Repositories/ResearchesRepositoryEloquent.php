<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\ResearchesRepository;
use ArqAdmin\Entities\Researches;

/**
 * Class ResearchesRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class ResearchesRepositoryEloquent extends BaseRepository implements ResearchesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Researches::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
