<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\SfmNacionalidadeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SfmNacionalidadePresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class SfmNacionalidadePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SfmNacionalidadeTransformer();
    }
}
