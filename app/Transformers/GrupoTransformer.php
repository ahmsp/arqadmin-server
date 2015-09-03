<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\Grupo;

/**
 * Class GrupoTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class GrupoTransformer extends TransformerAbstract
{

    /**
     * Transform the \Grupo entity
     * @param \Grupo $model
     *
     * @return array
     */
    public function transform(Grupo $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
