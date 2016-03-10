<?php

namespace ArqAdmin\Services;


use ArqAdmin\Image\Filters\Small;
use ArqAdmin\Repositories\DesenhoTecnicoRepository;
use ArqAdmin\Validators\DesenhoTecnicoValidator;
use Illuminate\Support\Facades\Storage;
use Imagick;
use Intervention\Image\Facades\Image;


class DesenhoTecnicoService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return DesenhoTecnicoRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return DesenhoTecnicoValidator::class;
    }

    public function showPublicImage($id, $maxSize = 300)
    {
        $disk = Storage::disk('local');
        $pathDocumental = 'acervos/documental/';
        $fileName = $this->repository->find($id)->arquivo_nome;

        if (!$exists = $disk->exists($pathDocumental . $fileName)) {
            abort(404, 'Imagem não encontrada.');
        }

        $imageFile = $disk->get($pathDocumental . $fileName);
        $filter = new Small($maxSize);
        $cache = false;

        if ($cache) {
            $cacheImage = Image::cache(function ($img) use ($imageFile, $filter) {
                $img->make($imageFile)->filter($filter);
            }, 10, true);
            $image = Image::make($cacheImage);
        } else {
            $image = Image::make($imageFile)->filter($filter);
        }

        return $image;
    }

    /**
     * @param $id
     * @param string $size
     * @return array
     *
     * Size template: medium|standard|large|original
     */
    public function downloadPublicImage($id, $size = 'standard')
    {
        $disk = Storage::disk('local');
        $pathDocumental = 'acervos/test/'; //todo: change to: acervos/documental_orig/
        $pathDownload = public_path() . '/acervos/downloads/';

        $originalName = $this->repository->find($id)->arquivo_original;
        $fileName = pathinfo($originalName, PATHINFO_FILENAME);
        $downloadFileName = "AHSP_DOC_" . $fileName . "_" . substr($size, 0, 3); //e.g. AHSP_DOC_OP_123123_1231_sta

        switch ($size) {
            case "medium":
                $maxSize = 1800;
                $resolution = 72;
                $downloadExtension = 'jpg';
                break;
            case "standard":
                $maxSize = 3600;
                $resolution = 300;
                $downloadExtension = 'jpg';
                break;
            case "large":
                $maxSize = 3600;
                $resolution = 300;
                $downloadExtension = 'tif';
                break;
            case "original":
                $downloadExtension = pathinfo($originalName, PATHINFO_EXTENSION);
                break;
        }

        // if already exists the download image
        if ($exists = $disk->exists($pathDownload . $downloadFileName . '.' . $downloadExtension)) {
            return [
                'file_path' => $pathDownload . $downloadFileName . '.' . $downloadExtension,
                'file_name' => $downloadFileName . '.' . $downloadExtension
            ];
        }

        // if the original image does not exists
        if (!$exists = $disk->exists($pathDocumental . $originalName)) {
            abort(404, 'Imagem não encontrada.');
        }

        if ($size == 'original') {
            $disk->copy($pathDocumental . $originalName, $pathDownload . $downloadFileName . '.' . $downloadExtension);
            return [
                'file_path' => $pathDownload . $downloadFileName . '.' . $downloadExtension,
                'file_name' => $downloadFileName . '.' . $downloadExtension
            ];
//            return [
//                'file_path' => storage_path('app/') . $pathDocumental . $originalName,
//                'file_name' => $downloadFileName . '.' . $downloadExtension
//            ];
        }

        $imageFile = $disk->get($pathDocumental . $originalName);

        $im = new Imagick;
        $im->readImageBlob($imageFile);
        $im->setImageResolution($resolution, $resolution);
        $im->resizeImage($maxSize, $maxSize, Imagick::FILTER_CATROM, 1, TRUE);
        $im->setFormat($downloadExtension);

        $savePath = storage_path('app/') . $pathDownload;
        $saveFile = $downloadFileName . '.' . $downloadExtension;

        $im->writeImage($savePath . $saveFile);

        return [
            'file_path' => $savePath . $saveFile,
            'file_name' => $saveFile
        ];
    }


    /**
     * @param $id
     * @param string $size
     * @return array
     *
     * Size template: medium|standard|large|original
     */
    public function getImageDownloadUrl($id, $size = 'standard')
    {
        // hash valid for today
        $hash = $this->hashDownload($id . $size);

        $urlDownload = url("download/imagem/cartografico/{$id}/{$size}/{$hash}");

        if (!$image = $this->downloadImage($id, $size)) {
            abort(404, 'Imagem não encontrada');
        }

        return ['url_download' => $urlDownload];
    }

    /**
     * @param $id
     * @param string $size
     * @return array
     *
     * Size template: medium|standard|large|original
     */
    public function downloadImage($id, $size)
    {
        $disk = Storage::disk('local');
        $pathDocumental = 'acervos/test/'; //todo: change to: acervos/documental_orig/
        $pathDownload = 'acervos/downloads/';

        $originalName = $this->repository->find($id)->arquivo_original;
        if (!$originalName || strlen($originalName) == 0) {
            abort(404, 'Imagem não encontrada.');
        }

        $fileName = pathinfo($originalName, PATHINFO_FILENAME);
        $downloadFileName = "AHSP_DOC_" . $fileName . "_" . substr($size, 0, 3); //e.g. AHSP_DOC_OP_123123_1231_sta

        switch ($size) {
            case "medium":
                $maxSize = 1800;
                $resolution = 72;
                $downloadExtension = 'jpg';
                break;
            case "standard":
                $maxSize = 3600;
                $resolution = 300;
                $downloadExtension = 'jpg';
                break;
            case "large":
                $maxSize = 3600;
                $resolution = 300;
                $downloadExtension = 'tif';
                break;
            case "original":
                $downloadExtension = pathinfo($originalName, PATHINFO_EXTENSION);
                break;
            default:
                $maxSize = 3600;
                $resolution = 300;
                $downloadExtension = 'jpg';
                break;
        }

        // if already exists the download image
        if ($disk->exists($pathDownload . $downloadFileName . '.' . $downloadExtension)) {
            return [
                'file_path' => storage_path('app/') . $pathDownload . $downloadFileName . '.' . $downloadExtension,
                'file_name' => $downloadFileName . '.' . $downloadExtension
            ];
        }

        // if the original image does not exists
        if (!$disk->exists($pathDocumental . $originalName)) {
            abort(404, 'Imagem não encontrada.');
        }

        if ($size == 'original') {
            return [
                'file_path' => storage_path('app/') . $pathDocumental . $originalName,
                'file_name' => $downloadFileName . '.' . $downloadExtension
            ];
        }

        $imageFile = $disk->get($pathDocumental . $originalName);

        $im = new Imagick;
        $im->readImageBlob($imageFile);
        $im->setImageResolution($resolution, $resolution);
        $im->resizeImage($maxSize, $maxSize, Imagick::FILTER_CATROM, 1, TRUE);
        $im->setFormat($downloadExtension);

        $savePath = storage_path('app/') . $pathDownload;
        $saveFile = $downloadFileName . '.' . $downloadExtension;

        $im->writeImage($savePath . $saveFile);

        return [
            'file_path' => $savePath . $saveFile,
            'file_name' => $saveFile
        ];
    }

    /**
     * Generate a hash value. When $userString is set, compares two strings
     *
     * @param $knownString
     * @param null $userString
     * @return bool|string
     */
    public function hashDownload($knownString, $userString = null)
    {
        $date = date('Ymd');
        $hash = hash('sha1', $knownString . $date);

        if ($userString && !($hash === $userString)) {
            return false;
        }

        return $hash;
    }
}