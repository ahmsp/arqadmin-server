<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\SfmNacionalidade;

/**
 * Class SfmNacionalidadeTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class SfmNacionalidadeTransformer extends TransformerAbstract
{

    /**
     * Transform the \SfmNacionalidade entity
     * @param \SfmNacionalidade $model
     *
     * @return array
     */
    public function transform(SfmNacionalidade $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
