<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\LcCompartimentoRepository;
use ArqAdmin\Entities\LcCompartimento;

/**
 * Class LcCompartimentoRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class LcCompartimentoRepositoryEloquent extends BaseRepository implements LcCompartimentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LcCompartimento::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
