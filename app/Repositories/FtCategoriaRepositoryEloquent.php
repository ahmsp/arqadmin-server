<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\FtCategoriaRepository;
use ArqAdmin\Entities\FtCategoria;

/**
 * Class FtCategoriaRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class FtCategoriaRepositoryEloquent extends BaseRepository implements FtCategoriaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FtCategoria::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
