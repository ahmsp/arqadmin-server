<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\DtEscala;

/**
 * Class DtEscalaTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class DtEscalaTransformer extends TransformerAbstract
{

    /**
     * Transform the \DtEscala entity
     * @param \DtEscala $model
     *
     * @return array
     */
    public function transform(DtEscala $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
