<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\DtTipoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DtTipoPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class DtTipoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DtTipoTransformer();
    }
}
