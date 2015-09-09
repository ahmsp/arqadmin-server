<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\SfmCausamortis;

/**
 * Class SfmCausamortisTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class SfmCausamortisTransformer extends TransformerAbstract
{

    /**
     * Transform the \SfmCausamortis entity
     * @param \SfmCausamortis $model
     *
     * @return array
     */
    public function transform(SfmCausamortis $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
