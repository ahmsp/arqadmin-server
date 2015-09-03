<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\Especiedocumental;

/**
 * Class EspeciedocumentalTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class EspeciedocumentalTransformer extends TransformerAbstract
{

    /**
     * Transform the \Especiedocumental entity
     * @param \Especiedocumental $model
     *
     * @return array
     */
    public function transform(Especiedocumental $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
