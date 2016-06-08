<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\Parameters;

/**
 * Class ParametersTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class ParametersTransformer extends TransformerAbstract
{

    /**
     * Transform the \Parameters entity
     * @param \Parameters $model
     *
     * @return array
     */
    public function transform(Parameters $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
