<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\Conservacao;

/**
 * Class ConservacaoTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class ConservacaoTransformer extends TransformerAbstract
{

    /**
     * Transform the \Conservacao entity
     * @param \Conservacao $model
     *
     * @return array
     */
    public function transform(Conservacao $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
