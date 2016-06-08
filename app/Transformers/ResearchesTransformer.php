<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\Researches;

/**
 * Class ResearchesTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class ResearchesTransformer extends TransformerAbstract
{

    /**
     * Transform the \Researches entity
     * @param \Researches $model
     *
     * @return array
     */
    public function transform(Researches $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
