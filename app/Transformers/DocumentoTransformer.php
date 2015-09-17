<?php

namespace ArqAdmin\Transformers;

use League\Fractal\TransformerAbstract;
use ArqAdmin\Entities\Documento;

/**
 * Class DocumentoTransformer
 * @package namespace ArqAdmin\Transformers;
 */
class DocumentoTransformer extends TransformerAbstract
{

    /**
     * Transform the \Documento entity
     * @param \Documento $model
     *
     * @return array
     */
    public function transform(Documento $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

//            'created_at' => $model->created_at,
//            'updated_at' => $model->updated_at
        ];
    }
}
