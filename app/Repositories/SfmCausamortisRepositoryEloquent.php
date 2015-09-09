<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\SfmCausamortisRepository;
use ArqAdmin\Entities\SfmCausamortis;

/**
 * Class SfmCausamortisRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class SfmCausamortisRepositoryEloquent extends BaseRepository implements SfmCausamortisRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SfmCausamortis::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
