<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\DtSuporteRepository;
use ArqAdmin\Entities\DtSuporte;

/**
 * Class DtSuporteRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class DtSuporteRepositoryEloquent extends BaseRepository implements DtSuporteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DtSuporte::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
