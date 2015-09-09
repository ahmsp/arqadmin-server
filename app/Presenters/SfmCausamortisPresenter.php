<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\SfmCausamortisTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SfmCausamortisPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class SfmCausamortisPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SfmCausamortisTransformer();
    }
}
