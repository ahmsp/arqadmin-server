<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\FtAmbienteRepository;
use ArqAdmin\Entities\FtAmbiente;

/**
 * Class FtAmbienteRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class FtAmbienteRepositoryEloquent extends BaseRepository implements FtAmbienteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FtAmbiente::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
