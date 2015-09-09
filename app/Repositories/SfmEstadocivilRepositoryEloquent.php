<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\SfmEstadocivilRepository;
use ArqAdmin\Entities\SfmEstadocivil;

/**
 * Class SfmEstadocivilRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class SfmEstadocivilRepositoryEloquent extends BaseRepository implements SfmEstadocivilRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SfmEstadocivil::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
