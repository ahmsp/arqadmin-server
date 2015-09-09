<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\DtConservacaoRepository;
use ArqAdmin\Entities\DtConservacao;

/**
 * Class DtConservacaoRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class DtConservacaoRepositoryEloquent extends BaseRepository implements DtConservacaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DtConservacao::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
