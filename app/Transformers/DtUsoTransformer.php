<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\DtUso;

/**
 * Class DtUsoTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class DtUsoTransformer extends TransformerAbstract
{

    /**
     * Transform the \DtUso entity
     * @param \DtUso $model
     *
     * @return array
     */
    public function transform(DtUso $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
