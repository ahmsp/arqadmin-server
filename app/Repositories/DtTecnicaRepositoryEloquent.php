<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\DtTecnicaRepository;
use ArqAdmin\Entities\DtTecnica;

/**
 * Class DtTecnicaRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class DtTecnicaRepositoryEloquent extends BaseRepository implements DtTecnicaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DtTecnica::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
