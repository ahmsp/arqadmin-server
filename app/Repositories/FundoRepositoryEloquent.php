<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\FundoRepository;
use ArqAdmin\Entities\Fundo;

/**
 * Class FundoRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class FundoRepositoryEloquent extends BaseRepository implements FundoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Fundo::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
