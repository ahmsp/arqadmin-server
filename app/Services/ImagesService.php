<?php

namespace ArqAdmin\Services;


use ArqAdmin\Image\Filters\PublicImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Imagick;
use Intervention\Image\Facades\Image;
use Storage;

/**
 * Class ImagesService
 * @package ArqAdmin\Services
 */
class ImagesService
{
    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    private $disk;

    /**
     * @var string
     */
    private $diskPath;

    /**
     * ImagesService constructor.
     */
    public function __construct()
    {
        $this->disk = Storage::disk('local');
        $this->diskPath = storage_path('app/');
    }

    /**
     * @return mixed
     */
    public function getDisk()
    {
        return $this->disk;
    }

    /**
     * @return string
     */
    public function getDiskPath()
    {
        return $this->diskPath;
    }

    /**
     * @return string
     */
    public function getDownloadPath()
    {
        return config('arqadmin.download_path');
    }

    /**
     * @return string
     */
    public function getPathCartograficoOriginal()
    {
        return config('arqadmin.path_cartografico_original');
    }

    /**
     * @return string
     */
    public function getPathCartograficoPublic()
    {
        return config('arqadmin.path_cartografico_public');
    }

    /**
     * @return string
     */
    public function getPathTextualOriginal()
    {
        return config('arqadmin.path_textual_original');
    }

    /**
     * @return string
     */
    public function getPathTextualPublic()
    {
        return config('arqadmin.path_textual_public');
    }

    /**
     * @return string
     */
    public function getPathFotograficoOriginal()
    {
        return config('arqadmin.path_fotografico_original');
    }

    /**
     * @return string
     */
    public function getPathFotograficoPublic()
    {
        return config('arqadmin.path_fotografico_public');
    }

    public function getPublicImage($acervo, $originalName, $maxSize)
    {
        $acervoPathOriginal = $this->getAcervoPathOriginal($acervo);
        $acervoPathPublic = $this->getAcervoPathPublic($acervo);
        $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '.jpg';

        $count = 0;
        $retries = 3;
        while (true) {
            try {
                $imageFile = $this->getDisk()->get($acervoPathPublic . $fileName);
                break;
            } catch (\Exception $e) {
                if ($count++ < $retries) {
                    sleep(0.1);
                } else {
//                    if ($this->getDisk()->has($acervoPathOriginal . $originalName)) {
//                        // make large (public) image
//                        $this->createImage($acervoPathOriginal . $originalName, 72, null, 'jpg', $acervoPathPublic . $fileName, 60);
//                    } else {
//                        return $this->getNotFoundImage();
//                    }
//                    break;
                    throw $e;
                }
            }
        }

        $filter = new PublicImage($maxSize);

        if (app()->environment() == 'production') {
            $cacheImage = Image::cache(function ($img) use ($imageFile, $filter) {
                $img->make($imageFile)->filter($filter);
            }, 15, true);
            $image = Image::make($cacheImage);
        } else {
            $image = Image::make($imageFile)->filter($filter);
        }

        if (!$maxSize || $maxSize > 320) {
            $image = $this->addWatermark($image);
        }

        return $image;
    }

    public function getNotFoundImage()
    {
//        $imageFile = public_path() . "/ico/no-image-75.png";
//        $cacheImage = Image::cache(function ($img) use ($imageFile) {
//            $img->make($imageFile);
//        }, 1440);
//
//        return Image::make($cacheImage);

//        return Image::make(public_path() . '/ico/no-image-75.png');

        abort(404, 'Imagem não encontrada.');
    }

    public function uploadImage(Request $request, $acervo)
    {
        $storagePath = $this->getDiskPath();
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $acervoPathOriginal = $this->getAcervoPathOriginal($acervo);
        $imagePath = $acervoPathOriginal . $originalName;

        if ($this->imageExists($imagePath)) {
            $this->softDelete($imagePath);
        }

        if (!$file->move($storagePath . $acervoPathOriginal, $originalName)) {
            abort(401, 'O arquivo enviado não pôde ser salvo');
        }

        // make large (public) image
        $acervoPathPublic = $this->getAcervoPathPublic($acervo);
        $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '.jpg';
        if (!$this->imageExists($acervoPathPublic . $originalName)) {
            $this->createImage($imagePath, 72, null, 'jpg', $acervoPathPublic . $fileName, 60);
        }

        return true;
    }

    /**
     * @param $imageFile string Image path into local storage. (e.g., 'images/filename.jpg')
     * @param $resolution
     * @param $maxSize
     * @param $extension
     * @param $saveFile string Image path into local storage. (e.g., 'images/filename.jpg')
     * @param null $quality Integer
     */
    public function createImage($imageFile, $resolution, $maxSize, $extension, $saveFile, $quality = null)
    {
        $image = $this->getDisk()->get($imageFile);
        $im = new Imagick;
        $im->readImageBlob($image);
        $im->setImageResolution($resolution, $resolution);

        if ($maxSize) {
            $im->resizeImage($maxSize, $maxSize, Imagick::FILTER_CATROM, 1, TRUE);
        }

        $im->setImageFormat($extension);
        $im->setFormat($extension);

        if ($quality) {
            $im->setImageCompression(Imagick::COMPRESSION_JPEG);
            $im->setImageCompressionQuality($quality);
        }

        if ($this->imageExists($saveFile)) {
            $this->softDelete($saveFile);
        }

        return $im->writeImage($this->getDiskPath() . $saveFile);
    }

    /**
     * @param $acervo string
     * @param $originalFileName string File name of original image (e.g, filename.tif)
     * @return array
     */
    public function removeOriginalAndRelatedImages($acervo, $originalFileName)
    {
        $originalDeletedFilename = null;
        $publicDeletedFilename = null;

        $acervoPathOriginal = $this->getAcervoPathOriginal($acervo);
        $originalFilePath = $acervoPathOriginal . $originalFileName;

        if ($this->imageExists($originalFilePath)) {
            $originalDeletedFilename = $this->softDelete($originalFilePath);
        }

        $acervoPathPublic = $this->getAcervoPathPublic($acervo);
        $publicFilePath = $acervoPathPublic . pathinfo($originalFileName, PATHINFO_FILENAME) . '.jpg';

        if ($this->imageExists($publicFilePath)) {
            $publicDeletedFilename = $this->softDelete($publicFilePath);
        }

        return [
            'originalDeletedFilename' => $originalDeletedFilename ?: null,
            'publicDeletedFilename' => $publicDeletedFilename ?: null
        ];
    }

    /**
     * @param $fromAcervo
     * @param $toAcervo
     * @param $originalFileName string File name of original image (e.g, filename.tif)
     */
    public function moveOriginalAndRelatedImages($fromAcervo, $toAcervo, $originalFileName)
    {
        // move original image
        $fromAcervoPathOriginal = $this->getAcervoPathOriginal($fromAcervo);
        $toAcervoPathOriginal = $this->getAcervoPathOriginal($toAcervo);
        $originalFilePath = $fromAcervoPathOriginal . $originalFileName;

        if ($this->imageExists($originalFilePath)) {
            $this->getDisk()->move($originalFilePath, $toAcervoPathOriginal . $originalFileName);
        }

        // move public image
        $fromAcervoPathPublic = $this->getAcervoPathPublic($fromAcervo);
        $toAcervoPathPublic = $this->getAcervoPathPublic($toAcervo);
        $publicFileName = pathinfo($originalFileName, PATHINFO_FILENAME) . '.jpg';
        $publicFilePath = $fromAcervoPathPublic . $publicFileName;

        if ($this->imageExists($publicFilePath)) {
            $this->getDisk()->move($publicFilePath, $toAcervoPathPublic . $publicFileName);
        }
    }

    /**
     * @param $imageFile string Image path into local storage. (e.g., 'images/filename.jpg')
     * @return bool
     */
    public function softDelete($imageFile)
    {
        if (!$imageFile) {
            return false;
        }

        $pathInfo = pathinfo($imageFile);

        if (!isset($pathInfo['extension'])) {
            return false;
        }

        $now = Carbon::now()->format('Y-m-d_His');
        $destinationPath = $pathInfo['dirname'] . '/removidos/';
        $destinationName = $pathInfo['filename'] . '_rm_' . $now . '.' . $pathInfo['extension'];

        if (!$this->getDisk()->move($imageFile, $destinationPath . $destinationName)) {
            return false;
        }

        return $destinationName;
    }

    public function getAcervoPathOriginal($acervo)
    {
        $paths = $this->getAcervoPath($acervo);
        return $paths['path_original'];
    }

    public function getAcervoPathPublic($acervo)
    {
        $paths = $this->getAcervoPath($acervo);
        return $paths['path_public'];
    }

    public function getAcervoPath($acervo)
    {
        switch ($acervo) {
            case 'cartografico';
                $pathOriginal = $this->getPathCartograficoOriginal();
                $pathPublic = $this->getPathCartograficoPublic();
                break;
            case 'textual';
                $pathOriginal = $this->getPathTextualOriginal();
                $pathPublic = $this->getPathTextualPublic();
                break;
            case 'fotografico';
                $pathOriginal = $this->getPathFotograficoOriginal();
                $pathPublic = $this->getPathFotograficoPublic();
                break;
            default;
                $pathOriginal = null;
                $pathPublic = null;
                break;
        }

        if (!$pathOriginal) {
            abort(404, 'Acervo not found');
        }

        return [
            'path_public' => $pathPublic,
            'path_original' => $pathOriginal
        ];
    }

    /**
     * @param $imagePath string Image path into local storage. (e.g., 'images/filename.jpg')
     * @return bool
     */
    public function imageExists($imagePath)
    {
        $disk = $this->getDisk();
        if ($disk->exists($imagePath)) {
            return true;
        }

        return false;
    }

    public function addWatermark(\Intervention\Image\Image $image)
    {
        $watermark = Image::make($this->getDiskPath() . 'acervos/watermark2.png');
        $watermark->fit($image->width(), $image->height());
        $image->insert($watermark, 'center');

        return $image;
    }

}