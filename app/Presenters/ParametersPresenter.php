<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\ParametersTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ParametersPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class ParametersPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ParametersTransformer();
    }
}
