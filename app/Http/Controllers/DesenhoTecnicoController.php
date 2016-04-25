<?php

namespace ArqAdmin\Http\Controllers;

use ArqAdmin\Http\Requests;
use ArqAdmin\Repositories\DesenhoTecnicoRepository;
use ArqAdmin\Services\DesenhoTecnicoService;
use Illuminate\Http\Request;

class DesenhoTecnicoController extends Controller
{
    /**
     * @var DesenhoTecnicoRepository
     */
    protected $repository;

    /**
     * @var DesenhoTecnicoService
     */
    protected $service;

    /**
     * @param DesenhoTecnicoRepository $repository
     * @param DesenhoTecnicoService $service
     */
    public function __construct(DesenhoTecnicoRepository $repository, DesenhoTecnicoService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $data = $this->repository->findAllWhere($params);

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return array
     */
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return array
     */
    public function show($id)
    {
        return $this->repository
            ->with(['dtTipo', 'dtSuporte', 'dtEscala', 'dtTecnica', 'dtConservacao'])
            ->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return array
     */
    public function update(Request $request, $id)
    {
        return $this->service->preUpdate($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return array
     */
    public function destroy($id)
    {
        return $this->service->deleteAndRemoveImage($id);
    }

    public function showPublicImage($id, $maxSize = 300)
    {
        $image = $this->service->showPublicImage($id, $maxSize);
        return $image->response('jpg', 100);
    }

    // Size template: medium|standard|large|original
    public function getDownloadUrl($id, $size)
    {
        $image = $this->service->getDownloadImageUrl($id, $size);

        return ['url_download' => $image['url_download']];
    }

    // Size template: medium|standard|large|original
    public function downloadImage($id, $size, $token)
    {
        if (!$image = $this->service->downloadImage($id, $size, $token)) {
            abort(404, 'Link não encontrado ou expirado!');
        }

        return response()->download($image['file_path'], $image['file_name']);
    }

    public function uploadImage(Request $request, $id)
    {
        return $this->service->upload($request, $id);
    }
}
