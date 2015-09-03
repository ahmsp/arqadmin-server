<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\AcervoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AcervoPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class AcervoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AcervoTransformer();
    }
}
