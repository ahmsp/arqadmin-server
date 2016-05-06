<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\FtCampoRepository;
use ArqAdmin\Entities\FtCampo;

/**
 * Class FtCampoRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class FtCampoRepositoryEloquent extends BaseRepository implements FtCampoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FtCampo::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
