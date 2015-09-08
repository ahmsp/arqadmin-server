<?php

namespace ArqAdmin\Presenters;

use ArqAdmin\Transformers\DocumentoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DocumentoPresenter
 *
 * @package namespace ArqAdmin\Presenters;
 */
class DocumentoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DocumentoTransformer();
    }
}
