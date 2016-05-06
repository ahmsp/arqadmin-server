<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\FtCromiaRepository;
use ArqAdmin\Entities\FtCromia;

/**
 * Class FtCromiaRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class FtCromiaRepositoryEloquent extends BaseRepository implements FtCromiaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FtCromia::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
