<?php

namespace ArqAdmin\Image\Filters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Large implements FilterInterface
{
    private $maxSize;
    private $encode;

    public function __construct($maxSize, $encode = 'jpg')
    {
        if (is_numeric($maxSize)) {
            $this->maxSize = intval($maxSize);
        }

        if (preg_match("/^(jpg|tif)$/i", $encode)) {
            $this->encode = $encode;
        }
    }

    public function applyFilter(Image $image)
    {
        $maxSize = $this->maxSize;

        $image->resize($maxSize, $maxSize, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $image->encode($this->encode, 100);

        return $image;
    }
}
