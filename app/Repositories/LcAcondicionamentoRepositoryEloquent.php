<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\LcAcondicionamentoRepository;
use ArqAdmin\Entities\LcAcondicionamento;

/**
 * Class LcAcondicionamentoRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class LcAcondicionamentoRepositoryEloquent extends BaseRepository implements LcAcondicionamentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LcAcondicionamento::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
