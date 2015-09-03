<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\DossieTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DossiePresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class DossiePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DossieTransformer();
    }
}
