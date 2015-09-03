<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\Subgrupo;

/**
 * Class SubgrupoTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class SubgrupoTransformer extends TransformerAbstract
{

    /**
     * Transform the \Subgrupo entity
     * @param \Subgrupo $model
     *
     * @return array
     */
    public function transform(Subgrupo $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
