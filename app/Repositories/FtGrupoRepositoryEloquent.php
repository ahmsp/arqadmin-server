<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\FtGrupoRepository;
use ArqAdmin\Entities\FtGrupo;

/**
 * Class FtGrupoRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class FtGrupoRepositoryEloquent extends BaseRepository implements FtGrupoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FtGrupo::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
