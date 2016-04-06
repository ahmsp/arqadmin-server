<?php

namespace ArqAdmin\Services;


use Illuminate\Http\Request;
use Imagick;
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
    private $diskLocal;

    /**
     * @var string
     */
    private $diskLocalPath;

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
     * ImagesService constructor.
     */
    public function __construct()
    {
        $this->diskLocal = Storage::disk('local');
        $this->diskLocalPath = storage_path('app/');
    }

    /**
     * @return mixed
     */
    public function getDiskLocal()
    {
        return $this->diskLocal;
    }

    /**
     * @return string
     */
    public function getDiskLocalPath()
    {
        return $this->diskLocalPath;
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

    /**
     * @param $imageFile
     * @param $resolution
     * @param $maxSize
     * @param $extension
     * @param $saveFile
     */
    public function makeImage($imageFile, $resolution, $maxSize, $extension, $saveFile)
    {
        $image = $this->diskLocal->get($imageFile);
        $im = new Imagick;
        $im->readImageBlob($image);
        $im->setImageResolution($resolution, $resolution);
        $im->resizeImage($maxSize, $maxSize, Imagick::FILTER_CATROM, 1, TRUE);
        $im->setFormat($extension);

        $im->writeImage($saveFile);
    }

    public function getAcervoPathOriginal($acervo)
    {
        switch ($acervo) {
            case 'cartografico';
                $acervoPath = $this->getPathCartograficoOriginal();
                break;
            case 'textual';
                $acervoPath = $this->getPathTextualOriginal();
                break;
            default;
                $acervoPath = null;
                break;
        }

        return $acervoPath;
    }

    public function getAcervoPathLarge($acervo)
    {
        switch ($acervo) {
            case 'cartografico';
                $acervoPath = $this->getPathCartograficoLarge();
                break;
            case 'textual';
                $acervoPath = $this->getPathTextualLarge();
                break;
            default;
                $acervoPath = null;
                break;
        }

        return $acervoPath;
    }

    public function imageExists($imagePath)
    {
        $disk = $this->getDiskLocal();
        if ($disk->exists($imagePath)) {
            return true;
        }

        return false;
    }

    public function uploadImage(Request $request)
    {
        $acervo = $request->input('acervo');
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $acervoPathOriginal = $this->getAcervoPathOriginal($acervo);
        $destination = $this->getDiskLocalPath() . $acervoPathOriginal;

        if (!$file->move($destination, $filename)) {
            abort(401, 'O arquivo enviado não pôde ser salvo');
        }

        // make large (public) image
        $acervoPathLarge = $this->getAcervoPathLarge($acervo);
        if(!$this->imageExists($acervoPathLarge . $filename)) {
            $this->makeImage($filename, 72, 1024, 'jpg', $acervoPathLarge . $filename);
        }

        return true;
    }

}