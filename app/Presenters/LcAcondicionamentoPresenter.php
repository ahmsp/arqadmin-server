<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\LcAcondicionamentoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class LcAcondicionamentoPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class LcAcondicionamentoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new LcAcondicionamentoTransformer();
    }
}
