<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\DesenhoTecnicoRepository;
use ArqAdmin\Validators\DesenhoTecnicoValidator;
use Carbon\Carbon;
use Illuminate\Container\Container as Application;
use Illuminate\Http\Request;

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

    /**
     * @param $id
     * @param int $maxSize Maximum size in pixels
     * @return mixed
     */
    public function showPublicImage($id, $maxSize = 300)
    {
        $data = $this->repository->find($id);
        $originalName = $data->arquivo_original;

        if (!$originalName || 0 === strlen($originalName)) {
            abort(404, 'Imagem não encontrada.');
        }

        return $this->imagesService->getPublicImage($data->acervo_tipo, $originalName, $maxSize);
    }

    public function createWithUpload(Request $request)
    {
        if (!$file = $request->hasFile('file')) {
            abort(401, 'O campo Imagem não contém um arquivo válido');
        }

        $file = $request->file('file');
        $data = $request->all();
        $data['arquivo_original'] = $file->getClientOriginalName();
        $data['arquivo_nome'] = pathinfo($data['arquivo_original'], PATHINFO_FILENAME) . '.jpg';

        if (true !== $validate = $this->validate($data)) {
            return $validate;
        }

        $this->imagesService->uploadImage($request);

        return $this->repository->create($data);
    }

    public function preUpdate($data, $id)
    {
        $oldData = $this->repository->find($id);

        $result = $this->update($data, $id);

        if ($result['success'] === true) {
            if ($oldData['acervo_tipo'] !== $data['acervo_tipo']) {
                $this->imagesService->moveOriginalAndRelatedImages(
                    $oldData['acervo_tipo'], $data['acervo_tipo'], $oldData->arquivo_original);
            }
        }
        
        return $result;
    }

    public function updateWithUpload(Request $request, $id)
    {
        $newData = $request->all();
        $file = $request->file('file');
        $newData['arquivo_original'] = $file->getClientOriginalName();
        $newData['arquivo_nome'] = pathinfo($newData['arquivo_original'], PATHINFO_FILENAME) . '.jpg';

        if (true !== $validate = $this->validate($newData)) {
            return $validate;
        }

        $oldData = $this->repository->find($id);
        $this->imagesService->removeOriginalAndRelatedImages($oldData->acervo_tipo, $oldData->arquivo_original);

        $this->imagesService->uploadImage($request);

        return $this->repository->update($newData, $id);
    }

    public function deleteAndRemoveImage($id)
    {
        $data = $this->repository->find($id);

        $delete = $this->delete($id);

        $this->imagesService->removeOriginalAndRelatedImages($data->acervo_tipo, $data->arquivo_original);

        return $delete;
    }

    /**
     * @param $id
     * @param string $size Size template parameters: medium|standard|large|original
     * @return array
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
     * @param string $size Size template parameters: medium|standard|large|original
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
