<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\LcCompartimentoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class LcCompartimentoPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class LcCompartimentoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new LcCompartimentoTransformer();
    }
}
