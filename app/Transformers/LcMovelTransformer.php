<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\LcMovel;

/**
 * Class LcMovelTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class LcMovelTransformer extends TransformerAbstract
{

    /**
     * Transform the \LcMovel entity
     * @param \LcMovel $model
     *
     * @return array
     */
    public function transform(LcMovel $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
