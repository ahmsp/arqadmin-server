<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\DtTecnicaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DtTecnicaPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class DtTecnicaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DtTecnicaTransformer();
    }
}
