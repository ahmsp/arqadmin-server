<?php

namespace ArqAdmin\Services;


use ArqAdmin\Image\Filters\Small;
use ArqAdmin\Repositories\DesenhoTecnicoRepository;
use ArqAdmin\Validators\DesenhoTecnicoValidator;
use Illuminate\Support\Facades\Storage;
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
//        return $image->response('jpg', 100);
    }

}