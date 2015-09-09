<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\DtConservacao;

/**
 * Class DtConservacaoTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class DtConservacaoTransformer extends TransformerAbstract
{

    /**
     * Transform the \DtConservacao entity
     * @param \DtConservacao $model
     *
     * @return array
     */
    public function transform(DtConservacao $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
