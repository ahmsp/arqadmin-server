<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\DtSuporte;

/**
 * Class DtSuporteTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class DtSuporteTransformer extends TransformerAbstract
{

    /**
     * Transform the \DtSuporte entity
     * @param \DtSuporte $model
     *
     * @return array
     */
    public function transform(DtSuporte $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
