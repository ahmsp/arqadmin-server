<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\AcervoRepository;
use ArqAdmin\Entities\Acervo;

/**
 * Class AcervoRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class AcervoRepositoryEloquent extends BaseRepository implements AcervoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Acervo::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
