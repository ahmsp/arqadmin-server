<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\Subserie;

/**
 * Class SubserieTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class SubserieTransformer extends TransformerAbstract
{

    /**
     * Transform the \Subserie entity
     * @param \Subserie $model
     *
     * @return array
     */
    public function transform(Subserie $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
