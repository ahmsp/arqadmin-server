<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Download extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'download';

    public $timestamps = false;

    protected $fillable = ['token', 'file_name', 'expiration_time', 'username', 'download_date'];
}
