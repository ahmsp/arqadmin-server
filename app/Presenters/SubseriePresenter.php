<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\SubserieTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SubseriePresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class SubseriePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SubserieTransformer();
    }
}
