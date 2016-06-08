<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Researches extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'researches';

    public $timestamps = false;

    protected $fillable = [
        'collection',
        'route',
        'query_string',
        'date',
        'users_id',
    ];

    public function parameters()
    {
        return $this->hasMany('ArqAdmin\Entities\Parameters');
    }


}
