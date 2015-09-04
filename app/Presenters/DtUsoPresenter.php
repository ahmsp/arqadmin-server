<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\DtUsoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DtUsoPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class DtUsoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DtUsoTransformer();
    }
}
