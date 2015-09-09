<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\SfmNaturalidade;

/**
 * Class SfmNaturalidadeTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class SfmNaturalidadeTransformer extends TransformerAbstract
{

    /**
     * Transform the \SfmNaturalidade entity
     * @param \SfmNaturalidade $model
     *
     * @return array
     */
    public function transform(SfmNaturalidade $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
