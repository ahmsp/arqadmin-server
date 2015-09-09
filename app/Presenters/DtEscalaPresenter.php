<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\DtEscalaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DtEscalaPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class DtEscalaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DtEscalaTransformer();
    }
}
