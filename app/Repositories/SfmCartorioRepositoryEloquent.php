<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\SfmCartorioRepository;
use ArqAdmin\Entities\SfmCartorio;

/**
 * Class SfmCartorioRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class SfmCartorioRepositoryEloquent extends BaseRepository implements SfmCartorioRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SfmCartorio::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
