<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\Dossie;

/**
 * Class DossieTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class DossieTransformer extends TransformerAbstract
{

    /**
     * Transform the \Dossie entity
     * @param \Dossie $model
     *
     * @return array
     */
    public function transform(Dossie $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
