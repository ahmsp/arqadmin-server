<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\GrupoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GrupoPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class GrupoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GrupoTransformer();
    }
}
