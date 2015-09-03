<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\EspeciedocumentalRepository;
use ArqAdmin\Entities\Especiedocumental;

/**
 * Class EspeciedocumentalRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class EspeciedocumentalRepositoryEloquent extends BaseRepository implements EspeciedocumentalRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Especiedocumental::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
