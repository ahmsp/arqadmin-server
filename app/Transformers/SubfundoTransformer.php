<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\Subfundo;

/**
 * Class SubfundoTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class SubfundoTransformer extends TransformerAbstract
{

    /**
     * Transform the \Subfundo entity
     * @param \Subfundo $model
     *
     * @return array
     */
    public function transform(Subfundo $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
