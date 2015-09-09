<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\RegistroSepultamentoRepository;
use ArqAdmin\Entities\RegistroSepultamento;

/**
 * Class RegistroSepultamentoRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class RegistroSepultamentoRepositoryEloquent extends BaseRepository implements RegistroSepultamentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RegistroSepultamento::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function findAllWhere()
    {
        $data = $this->model
            ->with('fundo', 'subfundo', 'grupo', 'subgrupo', 'serie', 'subserie', 'dossie',
                'especieDocumental', 'lcSala', 'lcMovel', 'lcCompartimento', 'lcAcondicionamento',
                'conservacao', 'sfmCartorio', 'sfmCemiterio', 'smfNacionalidade', 'sfmNaturalidade',
                'sfmEstadoscivil', 'sfmCausasMortis')
            ->paginate(100);
//        $data = $this->paginate(500);

        return $data;
    }
}
