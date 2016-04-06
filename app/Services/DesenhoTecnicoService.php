<?php

namespace ArqAdmin\Services;


use ArqAdmin\Image\Filters\Small;
use ArqAdmin\Repositories\DesenhoTecnicoRepository;
use ArqAdmin\Validators\DesenhoTecnicoValidator;
use Carbon\Carbon;
use Illuminate\Container\Container as Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * Class DesenhoTecnicoService
 * @package ArqAdmin\Services
 */
class DesenhoTecnicoService extends BaseService
{
    /**
     * @var DownloadService
     */
    private $downloadService;

    /**
     * @var ImagesService
     */
    private $imagesService;

//    /**
//     * @var string
//     */
//    private $pathCartografico = 'acervos/cartografico_orig/';
//
//    /**
//     * @var string
//     */
//    private $pathTextual = 'acervos/textual/';

    /**
     * DesenhoTecnicoService constructor.
     * @param Application $app
     * @param DownloadService $downloadService
     * @param ImagesService $imagesService
     */
    public function __construct(Application $app, DownloadService $downloadService, ImagesService $imagesService)
    {
        parent::__construct($app);

        $this->downloadService = $downloadService;
        $this->imagesService = $imagesService;
    }

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
        $pathDocumental = 'acervos/cartografico/';
        $fileName = $this->repository->find($id)->arquivo_nome;

        if (!$fileName || 0 === strlen($fileName)) {
            abort(404, 'Imagem não encontrada.');
        }

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

    public function upload(Request $request)
    {
        if (!$file = $request->hasFile('file')) {
            abort(401, 'O campo Imagem não contém um arquivo válido');
        }

        $file = $request->file('file');
        $data = $request->all();
        $data['arquivo_original'] = $file->getClientOriginalName();

        if (true !== $validate = $this->validate($data)) {
            return $validate;
        }

        $this->imagesService->uploadImage($request);
        
        return $this->repository->create($data);
    }

    /**
     * @param $id
     * @param string $size
     * @return array
     *
     * Size template: medium|standard|large|original
     */
    public function getDownloadImageUrl($id, $size)
    {
        $data = $this->repository->find($id);
        $originalName = $data->arquivo_original;
        $acervo = $data->acervo_tipo;

        if (!$originalName || 0 === strlen($originalName)) {
            abort(404, 'Imagem não encontrada.');
        }

        $makeImage = $this->downloadService->makeImage($acervo, $originalName, $size);
        $validation = $this->downloadService->generateValidation($makeImage['file_name']);
        $urlDownload = url("download/imagem/{$acervo}/{$id}/{$size}/{$validation->token}");

        return ['url_download' => $urlDownload];
    }

    /**
     * @param $id
     * @param string $size
     * @param string $token
     * @return array
     *
     */
    public function downloadImage($id, $size, $token)
    {
        $data = $this->repository->find($id);
        $originalName = $data->arquivo_original;
        $acervo = $data->acervo_tipo;

        $outOpts = $this->downloadService->outOptions();
        $outExtension = ('original' === $size) ?
            pathinfo($originalName, PATHINFO_EXTENSION) : $outOpts[$size]['extension'];

        $downloadFileName = $this->downloadService
            ->formatDownloadFileName($acervo, $originalName, $outExtension, $size);

        if (!$downloadRow = $this->downloadService->validateDownload($downloadFileName, $token)) {
            abort('401', 'Link não encontrado ou expirado!');
        }

        $downloadImage = $this->downloadService->makeImage($acervo, $originalName, $size);

        $this->downloadService->repository->update(['download_date' => Carbon::now()], $downloadRow->id);

        return $downloadImage;
    }
}
