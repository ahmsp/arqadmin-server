<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\DesenhoTecnico;

/**
 * Class DesenhoTecnicoTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class DesenhoTecnicoTransformer extends TransformerAbstract
{

    /**
     * Transform the \DesenhoTecnico entity
     * @param \DesenhoTecnico $model
     *
     * @return array
     */
    public function transform(DesenhoTecnico $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
