<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\EspeciedocumentalTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class EspeciedocumentalPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class EspeciedocumentalPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new EspeciedocumentalTransformer();
    }
}
