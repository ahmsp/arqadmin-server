<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\LcSala;

/**
 * Class LcSalaTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class LcSalaTransformer extends TransformerAbstract
{

    /**
     * Transform the \LcSala entity
     * @param \LcSala $model
     *
     * @return array
     */
    public function transform(LcSala $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
