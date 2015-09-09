<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\SfmNacionalidadeRepository;
use ArqAdmin\Entities\SfmNacionalidade;

/**
 * Class SfmNacionalidadeRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class SfmNacionalidadeRepositoryEloquent extends BaseRepository implements SfmNacionalidadeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SfmNacionalidade::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
