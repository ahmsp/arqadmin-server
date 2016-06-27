<?php

namespace ArqAdmin\Services;


use ArqAdmin\Entities\User;
use ArqAdmin\Repositories\DownloadRepository;
use ArqAdmin\Validators\DownloadValidator;
use Carbon\Carbon;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use Illuminate\Container\Container as Application;


/**
 * Class DownloadService
 * @package ArqAdmin\Services
 */
class DownloadService extends BaseService
{
    /**
     * @var ImagesService
     */
    private $imagesService;

    /**
     * DownloadService constructor.
     * @param Application $app
     * @param ImagesService $imagesService
     */
    public function __construct(Application $app, ImagesService $imagesService)
    {
        parent::__construct($app);

        $this->imagesService = $imagesService;
    }

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
     * @param $originalName
     * @param string $size template: medium|standard|large|original
     * @return array
     */
    public function makeImage($acervo, $originalName, $size)
    {
        $storagePath = $this->imagesService->getDiskPath();
        $outOpts = $this->outOptions();
        $extension = ('original' === $size) ? pathinfo($originalName, PATHINFO_EXTENSION) : $outOpts[$size]['extension'];

        $downloadPath = $this->imagesService->getDownloadPath();
        $downloadFileName = $this->formatDownloadFileName($acervo, $originalName, $extension, $size);

        // if already exists the download image
        if ($this->imagesService->imageExists($downloadPath . $downloadFileName)) {
            return [
                'file_path' => $storagePath . $downloadPath . $downloadFileName,
                'file_name' => $downloadFileName,
            ];
        }

        $originalImagePath = $this->imagesService->getAcervoPathOriginal($acervo);

        // if the original image does not exists
        if (!$this->imagesService->imageExists($originalImagePath . $originalName)) {
            abort(404, 'Imagem não encontrada.');
        }

        if ($size == 'original') {
            return [
                'file_path' => $storagePath . $originalImagePath . $originalName,
                'file_name' => $downloadFileName,
            ];
        }

        $resolution = $outOpts[$size]['resolution'];
        $maxSize = $outOpts[$size]['maxSize'];
        $imageFile = $originalImagePath . $originalName;
        $savePath = $downloadPath . $downloadFileName;

        $this->imagesService->makeImage($imageFile, $resolution, $maxSize, $extension, $savePath);

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
        $downloadFileName = $prefix . $fileName . "_" . substr($size, 0, 3); //e.g. AHSP_CAR_OP_123123_1231_sta

        return $downloadFileName . "." . $outExtension;
    }

    /**
     * Generate a download validation
     *
     * @param $acervo
     * @param $downloadFileName
     * @return mixed
     */
    public function generateValidation($acervo, $downloadFileName)
    {
        do {
            $token = $this->makeRandomToken();
        } while ($res = null === $this->repository->findByField('token', $token));

//        $userId = Authorizer::getResourceOwnerId();
//        $username = User::find($userId)->username;
        $username = User::find(auth()->id())->username;

        $validator = $this->repository->create([
            'token' => $token,
            'file_name' => $downloadFileName,
            'collection_type' => $acervo,
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
     * @param string $token (string, 12 chars)
     * @return mixed
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

        return null;
    }

    /**
     * Validate a URL input
     *
     * @param string $token (string, 12 chars)
     * @return mixed
     */
    function validateDatasheetDownload($token)
    {
        if (preg_match('/^[0-9A-Z]{12}$/i', $token)) {
            $downloadRow = $this->repository->findByField('token', $token)->first();

            if ($downloadRow
                && $downloadRow->file_name
                && !$downloadRow->download_date
                && Carbon::now() <= $downloadRow->expiration_time
            ) {
                return $downloadRow;
            }
        }

        return null;
    }

}
