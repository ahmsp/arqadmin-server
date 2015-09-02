<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\FundoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FundoPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class FundoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FundoTransformer();
    }
}
