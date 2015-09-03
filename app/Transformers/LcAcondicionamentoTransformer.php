<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\LcAcondicionamento;

/**
 * Class LcAcondicionamentoTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class LcAcondicionamentoTransformer extends TransformerAbstract
{

    /**
     * Transform the \LcAcondicionamento entity
     * @param \LcAcondicionamento $model
     *
     * @return array
     */
    public function transform(LcAcondicionamento $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
