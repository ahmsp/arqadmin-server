<?php

namespace ArqAdmin\Services;


use ArqAdmin\Image\Filters\Small;
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
        $acervoPath = $this->getAcervoPathPublic($acervo);
        $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '.jpg';

        if (!$this->imageExists($acervoPath . $fileName)) {
            if (!$this->imageExists($acervoPathOriginal . $originalName)) {
                return $this->getNotFoundImage();
//                abort(404, 'Imagem não encontrada.');
            }
            $this->makeImage(
                $acervoPathOriginal . $originalName, 72, 1024, 'jpg', $acervoPath . $fileName);
        }

        $imageFile = $this->getDisk()->get($acervoPath . $fileName);
        $filter = new Small($maxSize);

        if (app()->environment() == 'production') {
            $cacheImage = Image::cache(function ($img) use ($imageFile, $filter) {
                $img->make($imageFile)->filter($filter);
            }, 15, true);
            $image = Image::make($cacheImage);
        } else {
            $image = Image::make($imageFile)->filter($filter);
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
            $this->makeImage(
                $imagePath, 72, 1024, 'jpg', $acervoPathPublic . $fileName);
        }

        return true;
    }

    /**
     * @param $imageFile string Image path into local storage. (e.g., 'images/filename.jpg')
     * @param $resolution
     * @param $maxSize
     * @param $extension
     * @param $saveFile string Image path into local storage. (e.g., 'images/filename.jpg')
     */
    public function makeImage($imageFile, $resolution, $maxSize, $extension, $saveFile)
    {
        $image = $this->getDisk()->get($imageFile);
        $im = new Imagick;
        $im->readImageBlob($image);
        $im->setImageResolution($resolution, $resolution);
        $im->resizeImage($maxSize, $maxSize, Imagick::FILTER_CATROM, 1, TRUE);
        $im->setFormat($extension);

        if ($this->imageExists($saveFile)) {
            $this->softDelete($saveFile);
        }

        $storagePath = $this->getDiskPath();
        $im->writeImage($storagePath . $saveFile);
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
        $filePath = $acervoPathPublic . pathinfo($originalFileName, PATHINFO_FILENAME) . '.jpg';

        if ($this->imageExists($filePath)) {
            $publicDeletedFilename = $this->softDelete($filePath);
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
                $pathOriginal = $pathPublic = null;
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

}