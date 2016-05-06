<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\Fotografia;

/**
 * Class FotografiaTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class FotografiaTransformer extends TransformerAbstract
{

    /**
     * Transform the \Fotografia entity
     * @param \Fotografia $model
     *
     * @return array
     */
    public function transform(Fotografia $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
