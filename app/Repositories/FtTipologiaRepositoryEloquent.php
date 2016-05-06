<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\FtTipologiaRepository;
use ArqAdmin\Entities\FtTipologia;

/**
 * Class FtTipologiaRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class FtTipologiaRepositoryEloquent extends BaseRepository implements FtTipologiaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FtTipologia::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
