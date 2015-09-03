<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\SubgrupoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SubgrupoPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class SubgrupoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SubgrupoTransformer();
    }
}
