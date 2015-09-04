<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\LcSalaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class LcSalaPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class LcSalaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new LcSalaTransformer();
    }
}
