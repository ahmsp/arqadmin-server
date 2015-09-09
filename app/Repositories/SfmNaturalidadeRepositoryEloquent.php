<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\SfmNaturalidadeRepository;
use ArqAdmin\Entities\SfmNaturalidade;

/**
 * Class SfmNaturalidadeRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class SfmNaturalidadeRepositoryEloquent extends BaseRepository implements SfmNaturalidadeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SfmNaturalidade::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
