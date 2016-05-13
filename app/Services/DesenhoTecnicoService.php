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

    public function preUpdate($data, $id)
    {
        $oldData = $this->repository->find($id);

        $result = $this->update($data, $id);

        if ($result) {
            if (isset($data['arquivo_original']) && $oldData['arquivo_original'] !== $data['arquivo_original']) {
                abort(400, 'As imagens existentes não podem ser sobrescritas.');
            }

            if (isset($data['acervo_tipo']) && $oldData['acervo_tipo'] !== $data['acervo_tipo']) {
                $this->imagesService->moveOriginalAndRelatedImages(
                    $oldData['acervo_tipo'], $data['acervo_tipo'], $oldData->arquivo_original);
            }

        }

        return $result;
    }

    public function upload(Request $request, $id)
    {
        if (!$request->hasFile('file')) {
            abort(401, 'Dados de upload de imagem inválidos');
        }

        $model = $this->repository->find($id);
        $file = $request->file('file');

        $data['arquivo_original'] = $file->getClientOriginalName();
        $data['arquivo_nome'] = pathinfo($data['arquivo_original'], PATHINFO_FILENAME) . '.jpg';

        $filenameExists = $this->repository->findWhere([
            'arquivo_original' => $data['arquivo_original'],
            ['id', '<>', $id]
        ]);

        if (empty($filenameExists)) {
            abort(401, 'O nome do arquivo já existe e não pode ser duplicado');
        }

        $this->imagesService->uploadImage($request, $model->acervo_tipo);

        return $this->update($data, $model->id);
    }

    public function deleteAndRemoveImage($id)
    {
        $data = $this->repository->find($id);

        $removedImages = $this->imagesService->removeOriginalAndRelatedImages($data->acervo_tipo, $data->arquivo_original);

        $this->update(
            [
                'arquivo_original' => $removedImages['originalDeletedFilename'],
                'arquivo_nome' => $removedImages['publicDeletedFilename']
            ],
            $id
        );

        $delete = $this->delete($id);

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
        $urlDownload = url("imagem/download/documental/{$id}/{$size}/{$validation->token}");

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
