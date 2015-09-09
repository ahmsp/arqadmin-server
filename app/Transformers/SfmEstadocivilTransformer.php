<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\SfmEstadocivil;

/**
 * Class SfmEstadocivilTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class SfmEstadocivilTransformer extends TransformerAbstract
{

    /**
     * Transform the \SfmEstadocivil entity
     * @param \SfmEstadocivil $model
     *
     * @return array
     */
    public function transform(SfmEstadocivil $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
