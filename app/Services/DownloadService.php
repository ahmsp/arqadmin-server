<?php

namespace ArqAdmin\Services;


use ArqAdmin\Models\User;
use ArqAdmin\Repositories\DownloadRepository;
use ArqAdmin\Validators\DownloadValidator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Imagick;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;


/**
 * Class DownloadService
 * @package ArqAdmin\Services
 */
class DownloadService extends BaseService
{
    /**
     * @var string
     */
    private $downloadPath = 'acervos/downloads/';

    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return DownloadRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return DownloadValidator::class;
    }

    /**
     * @param $acervo
     * @param $imagePath
     * @param $originalName
     * @param string $size template: medium|standard|large|original
     * @return array
     */
    public function makeImage($acervo, $imagePath, $originalName, $size)
    {
        $disk = Storage::disk('local');
        $outOpts = $this->outOptions();
        $extension = 'original' === $size ? pathinfo($originalName, PATHINFO_EXTENSION) : $outOpts[$size]['extension'];

        $downloadFileName = $this->formatDownloadFileName($acervo, $originalName, $extension, $size);

        // if already exists the download image
        if ($disk->exists($this->downloadPath . $downloadFileName)) {
            return [
                'file_path' => storage_path('app/') . $this->downloadPath . $downloadFileName,
                'file_name' => $downloadFileName,
            ];
        }

        // if the original image does not exists
        if (!$disk->exists($imagePath . $originalName)) {
            abort(404, 'Imagem não encontrada.');
        }

        if ($size == 'original') {
            return [
                'file_path' => storage_path('app/') . $imagePath . $originalName,
                'file_name' => $downloadFileName,
            ];
        }

        $resolution = $outOpts[$size]['resolution'];
        $maxSize = $outOpts[$size]['maxSize'];

        $imageFile = $disk->get($imagePath . $originalName);
        $im = new Imagick;
        $im->readImageBlob($imageFile);
        $im->setImageResolution($resolution, $resolution);
        $im->resizeImage($maxSize, $maxSize, Imagick::FILTER_CATROM, 1, TRUE);
        $im->setFormat($extension);

        $savePath = storage_path('app/') . $this->downloadPath;

        $im->writeImage($savePath . $downloadFileName);

        return [
            'file_path' => $savePath . $downloadFileName,
            'file_name' => $downloadFileName,
        ];
    }

    /**
     * @return array
     */
    public function outOptions()
    {
        return [
            'medium' => [
                'maxSize' => '1800',
                'resolution' => '72',
                'extension' => 'jpg',
            ],
            'standard' => [
                'maxSize' => '3600',
                'resolution' => '300',
                'extension' => 'jpg',
            ],
            'large' => [
                'maxSize' => '3600',
                'resolution' => '300',
                'extension' => 'tif',
            ]
        ];
    }

    /**
     * @param $acervo
     * @param $originalName
     * @param $outExtension
     * @param $size
     * @return string
     */
    public function formatDownloadFileName($acervo, $originalName, $outExtension, $size)
    {
        $fileName = pathinfo($originalName, PATHINFO_FILENAME);
        $prefix = "AHSP_" . strtoupper(substr($acervo, 0, 3)) . "_"; //e.g. AHSP_CAR_
        $downloadFileName = $prefix . $fileName . "_" . substr($size, 0, 3); //e.g. AHSP_DOC_OP_123123_1231_sta

        return $downloadFileName . "." . $outExtension;
    }

    /**
     * Generate a download validation
     *
     * @param $downloadFileName
     * @return mixed
     */
    public function generateValidation($downloadFileName)
    {
        do {
            $token = $this->makeRandomToken();
        } while ($res = null === $this->repository->findByField('token', $token));

        $userId = Authorizer::getResourceOwnerId();
        $username = User::find($userId)->username;

        $validator = $this->repository->create([
            'token' => $token,
            'file_name' => $downloadFileName,
            'expiration_time' => Carbon::now()->addDay(),
            'username' => $username
        ]);

        return $validator;
    }

    /**
     * Generate a selector
     *
     * @return string (12 characters)
     */
    function makeRandomToken()
    {
        return strtr(
            base64_encode(
                openssl_random_pseudo_bytes(9)
            ),
            '+/=',
            'XYZ'
        );
    }

    /**
     * Validate a URL input
     *
     * @param $downloadFileName
     * @param string $selector (string, 12 chars)
     * @return bool
     */
    function validateDownload($downloadFileName, $token)
    {
        if (preg_match('/^[0-9A-Z]{12}$/i', $token)) {

            $downloadRow = $this->repository->findByField('token', $token)->first();

            if ($downloadRow
                && $downloadRow->file_name
                && $downloadRow->file_name === $downloadFileName
                && !$downloadRow->download_date
                && Carbon::now() <= $downloadRow->expiration_time
            ) {
                return $downloadRow;
            }
        }

        return false;
    }

}