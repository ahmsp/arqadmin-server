<?php

namespace ArqAdmin\Image\Filters;


class Download
{
    /**
     * Download constructor.
     */
    public function __construct()
    {

    }

    public function resize()
    {
        $imPath = "/Users/cyro/Workbench/Projects/proj.ahsp/AhspArqAdmin/server-api/storage/app/acervos/test/";
        $imName = "OP1915_004164_PR001.cr2";

        $imageFile = Storage::disk('local')->get('acervos/test/' . $imName);

        $im = new \Imagick;
        $im->readImageBlob($imageFile);

        $im->setImageResolution(300, 300);
//        $im->scaleImage(3600, 3600, true);
        $im->resizeImage(5000, 5000, \Imagick::FILTER_LANCZOS, 1, TRUE);
        $im->setFormat('jpg');
        $im->writeImage($imPath . 'test5000.jpg');

        echo 'end';


        // CATROM very similar result to LANCZOS, but is significantly faster.
//        $im->resizeImage(200, 200,  imagick::FILTER_LANCZOS, 1, TRUE);



//        destroy

//        dd($basename);
//        return $id;

//        return response()->download($image);
//        return response()->download($pathToFile, $name, $headers);
//        return $im->response('jpg', 100);

        return 'imagick ok';
    }
//    public function applyFilter(Image $image)
//    {
//        return $image->fit(240, 180);
//    }
}