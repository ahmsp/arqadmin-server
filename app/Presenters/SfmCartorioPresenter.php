<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\SfmCartorioTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SfmCartorioPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class SfmCartorioPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SfmCartorioTransformer();
    }
}
