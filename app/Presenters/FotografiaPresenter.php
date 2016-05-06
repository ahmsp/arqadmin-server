<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\FotografiaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FotografiaPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class FotografiaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FotografiaTransformer();
    }
}
