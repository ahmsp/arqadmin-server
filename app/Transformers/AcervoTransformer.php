<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\Acervo;

/**
 * Class AcervoTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class AcervoTransformer extends TransformerAbstract
{

    /**
     * Transform the \Acervo entity
     * @param \Acervo $model
     *
     * @return array
     */
    public function transform(Acervo $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
