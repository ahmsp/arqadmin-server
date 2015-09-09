<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\DtTipoRepository;
use ArqAdmin\Entities\DtTipo;

/**
 * Class DtTipoRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class DtTipoRepositoryEloquent extends BaseRepository implements DtTipoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DtTipo::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
