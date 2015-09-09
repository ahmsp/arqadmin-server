<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\DtTipo;

/**
 * Class DtTipoTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class DtTipoTransformer extends TransformerAbstract
{

    /**
     * Transform the \DtTipo entity
     * @param \DtTipo $model
     *
     * @return array
     */
    public function transform(DtTipo $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
