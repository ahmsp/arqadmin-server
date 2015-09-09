<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\RegistroSepultamento;

/**
 * Class RegistroSepultamentoTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class RegistroSepultamentoTransformer extends TransformerAbstract
{

    /**
     * Transform the \RegistroSepultamento entity
     * @param \RegistroSepultamento $model
     *
     * @return array
     */
    public function transform(RegistroSepultamento $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
