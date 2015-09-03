<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\LcCompartimento;

/**
 * Class LcCompartimentoTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class LcCompartimentoTransformer extends TransformerAbstract
{

    /**
     * Transform the \LcCompartimento entity
     * @param \LcCompartimento $model
     *
     * @return array
     */
    public function transform(LcCompartimento $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
