<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\ConservacaoRepository;
use ArqAdmin\Entities\Conservacao;

/**
 * Class ConservacaoRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class ConservacaoRepositoryEloquent extends BaseRepository implements ConservacaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Conservacao::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
