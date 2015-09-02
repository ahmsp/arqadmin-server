<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\Fundo;

/**
 * Class FundoTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class FundoTransformer extends TransformerAbstract
{

    /**
     * Transform the \Fundo entity
     * @param \Fundo $model
     *
     * @return array
     */
    public function transform(Fundo $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
