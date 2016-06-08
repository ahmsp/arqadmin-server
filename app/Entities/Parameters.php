<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Parameters extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'parameters';

    public $timestamps = false;

    protected $fillable = ['property', 'value', 'operator'];

    public function research()
    {
        return $this->belongsTo('ArqAdmin\Entities\Researches', 'researches_id');
    }

}
