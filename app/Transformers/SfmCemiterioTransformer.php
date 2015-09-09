<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\SfmCemiterio;

/**
 * Class SfmCemiterioTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class SfmCemiterioTransformer extends TransformerAbstract
{

    /**
     * Transform the \SfmCemiterio entity
     * @param \SfmCemiterio $model
     *
     * @return array
     */
    public function transform(SfmCemiterio $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
