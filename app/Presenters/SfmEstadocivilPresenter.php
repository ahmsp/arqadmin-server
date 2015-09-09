<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\SfmEstadocivilTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SfmEstadocivilPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class SfmEstadocivilPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SfmEstadocivilTransformer();
    }
}
