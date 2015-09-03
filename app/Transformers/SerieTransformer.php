<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\Serie;

/**
 * Class SerieTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class SerieTransformer extends TransformerAbstract
{

    /**
     * Transform the \Serie entity
     * @param \Serie $model
     *
     * @return array
     */
    public function transform(Serie $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
