<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\ConservacaoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ConservacaoPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class ConservacaoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ConservacaoTransformer();
    }
}
