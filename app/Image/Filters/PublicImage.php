<?php

namespace ArqAdmin\Image\Filters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class PublicImage implements FilterInterface
{
    private $maxSize = null;

    public function __construct($maxSize = null)
    {
        if (is_numeric($maxSize)) {
            $this->maxSize = intval($maxSize);
        }
    }

    public function applyFilter(Image $image)
    {
        $w = $image->width();
        $h = $image->height();
        $largerSize = $w > $h ? $w : $h;

        if ($this->maxSize && $this->maxSize < $largerSize) {
            $image->resize($this->maxSize, $this->maxSize, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        return $image->encode('jpg', 60);
    }
}
