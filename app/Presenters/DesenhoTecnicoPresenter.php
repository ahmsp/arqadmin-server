<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\DesenhoTecnicoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DesenhoTecnicoPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class DesenhoTecnicoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DesenhoTecnicoTransformer();
    }
}
