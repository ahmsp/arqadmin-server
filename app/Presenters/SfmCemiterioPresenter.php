<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\SfmCemiterioTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SfmCemiterioPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class SfmCemiterioPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SfmCemiterioTransformer();
    }
}
