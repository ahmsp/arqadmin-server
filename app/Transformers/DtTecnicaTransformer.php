<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\DtTecnica;

/**
 * Class DtTecnicaTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class DtTecnicaTransformer extends TransformerAbstract
{

    /**
     * Transform the \DtTecnica entity
     * @param \DtTecnica $model
     *
     * @return array
     */
    public function transform(DtTecnica $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
