<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\DtSuporteTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DtSuportePresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class DtSuportePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DtSuporteTransformer();
    }
}
