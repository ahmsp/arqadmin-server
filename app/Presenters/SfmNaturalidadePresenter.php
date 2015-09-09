<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\SfmNaturalidadeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SfmNaturalidadePresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class SfmNaturalidadePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SfmNaturalidadeTransformer();
    }
}
