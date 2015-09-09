<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\DtConservacaoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DtConservacaoPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class DtConservacaoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DtConservacaoTransformer();
    }
}
