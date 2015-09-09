<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\RegistroSepultamentoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RegistroSepultamentoPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class RegistroSepultamentoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RegistroSepultamentoTransformer();
    }
}
