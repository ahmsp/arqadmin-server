<?php

namespace ArqAdmin\Image\Filters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Small implements FilterInterface
{
    private $maxSize = 300;

    public function __construct($maxSize = 300)
    {
        if (is_numeric($maxSize) && $maxSize <= 1024) {
            $this->maxSize = intval($maxSize);
        }
    }

    public function applyFilter(Image $image)
    {
        $maxSize = $this->maxSize;
        $image->resize($maxSize, $maxSize, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $image->encode('jpg', 70);

        return $image;
    }
}
