<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\FtFundoRepository;
use ArqAdmin\Entities\FtFundo;

/**
 * Class FtFundoRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class FtFundoRepositoryEloquent extends BaseRepository implements FtFundoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FtFundo::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
