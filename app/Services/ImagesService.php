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
     * @var string
     */
    private $downloadPath = 'acervos/downloads/';

    /**
     * @var string
     */
    private $pathCartograficoOriginal = 'acervos/cartografico_orig/';

    /**
     * @var string
     */
    private $pathCartograficoLarge = 'acervos/cartografico/';

    /**
     * @var string
     */
    private $pathTextualOriginal = 'acervos/textual_orig/';

    /**
     * @var string
     */
    private $pathTextualLarge = 'acervos/textual/';

    /**
     * @var bool
     */
    private $cache = false;

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
        return $this->downloadPath;
    }

    /**
     * @return string
     */
    public function getPathCartograficoOriginal()
    {
        return $this->pathCartograficoOriginal;
    }

    /**
     * @return string
     */
    public function getPathCartograficoLarge()
    {
        return $this->pathCartograficoLarge;
    }

    /**
     * @return string
     */
    public function getPathTextualOriginal()
    {
        return $this->pathTextualOriginal;
    }

    /**
     * @return string
     */
    public function getPathTextualLarge()
    {
        return $this->pathTextualLarge;
    }

    public function getPublicImage($acervo, $originalName, $maxSize)
    {
        $storagePath = $this->getDiskPath();
        $acervoPathOriginal = $this->getAcervoPathOriginal($acervo);
        $acervoPath = $this->getAcervoPathPublic($acervo);
        $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '.jpg';

        if (!$this->imageExists($acervoPath . $fileName)) {
            if (!$this->imageExists($acervoPathOriginal . $originalName)) {
                abort(404, 'Imagem não encontrada.');
            }
            $this->makeImage(
                $acervoPathOriginal . $originalName, 72, 1024, 'jpg', $acervoPath . $fileName);
        }

        $imageFile = $this->getDisk()->get($acervoPath . $fileName);
        $filter = new Small($maxSize);

        if ($this->cache) {
            $cacheImage = Image::cache(function ($img) use ($imageFile, $filter) {
                $img->make($imageFile)->filter($filter);
            }, 10, true);
            $image = Image::make($cacheImage);
        } else {
            $image = Image::make($imageFile)->filter($filter);
        }

        return $image;
    }

    public function uploadImage(Request $request)
    {
        $storagePath = $this->getDiskPath();
        $acervo = $request->input('acervo_tipo');
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
        $acervoPathLarge = $this->getAcervoPathPublic($acervo);
        $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '.jpg';
        if (!$this->imageExists($acervoPathLarge . $originalName)) {
            $this->makeImage(
                $imagePath, 72, 1024, 'jpg', $acervoPathLarge . $fileName);
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
     * @param $imageFile string Image path into local storage. (e.g., 'images/filename.jpg')
     * @return bool
     */
    public function softDelete($imageFile)
    {
        $now = Carbon::now()->format('Y-m-d_His');
        $pathInfo = pathinfo($imageFile);
        $destinationPath = $pathInfo['dirname'] . '/removidos/';
        $destinationName = $pathInfo['filename'] . '_rm_' . $now . '.' . $pathInfo['extension'];

        if (!$this->getDisk()->move($imageFile, $destinationPath . $destinationName)) {
            abort(401, 'This file already exists and could not be moved to another directory');
        }

        return true;
    }

    public function getAcervoPathOriginal($acervo)
    {
        $paths = $this->getAcervoPath($acervo);
        return $paths['path_original'];
    }

    public function getAcervoPathPublic($acervo)
    {
        $paths = $this->getAcervoPath($acervo);
        return $paths['path'];
    }

    public function getAcervoPath($acervo)
    {
        switch ($acervo) {
            case 'cartografico';
                $pathOriginal = $this->getPathCartograficoOriginal();
                $path = $this->getPathCartograficoLarge();
                break;
            case 'textual';
                $pathOriginal = $this->getPathTextualOriginal();
                $path = $this->getPathTextualLarge();
                break;
            default;
                $pathOriginal = $path = null;
                break;
        }

        if (!$pathOriginal) {
            abort(404, 'Acervo not found');
        }

        return [
            'path' => $path,
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