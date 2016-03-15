<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\DownloadRepository;
use ArqAdmin\Entities\Download;

/**
 * Class DownloadRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class DownloadRepositoryEloquent extends BaseRepository implements DownloadRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Download::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
