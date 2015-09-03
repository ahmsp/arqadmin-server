<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\SubfundoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SubfundoPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class SubfundoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SubfundoTransformer();
    }
}
