<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\LcMovelTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class LcMovelPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class LcMovelPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new LcMovelTransformer();
    }
}
