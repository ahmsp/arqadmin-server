<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\ResearchesTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ResearchesPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class ResearchesPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ResearchesTransformer();
    }
}
