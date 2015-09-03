<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\SerieTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SeriePresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class SeriePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SerieTransformer();
    }
}
