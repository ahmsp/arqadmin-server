<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\SfmCartorio;

/**
 * Class SfmCartorioTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class SfmCartorioTransformer extends TransformerAbstract
{

    /**
     * Transform the \SfmCartorio entity
     * @param \SfmCartorio $model
     *
     * @return array
     */
    public function transform(SfmCartorio $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
