<?php

namespace ArqAdmin\Http\Controllers;

use ArqAdmin\Http\Requests;
use ArqAdmin\Repositories\DocumentoRepository;
use ArqAdmin\Services\DocumentoService;
use ArqAdmin\Services\ResearchesService;
use Illuminate\Http\Request;


class DocumentoController extends Controller
{
    /**
     * @var DocumentoRepository
     */
    protected $repository;

    /**
     * @var DocumentoService
     */
    protected $service;
    /**
     * @var ResearchesService
     */
    private $researchesService;

    /**
     * @param DocumentoRepository $repository
     * @param DocumentoService $service
     * @param ResearchesService $researchesService
     */
    public function __construct(DocumentoRepository $repository, DocumentoService $service,
                                ResearchesService $researchesService)
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->researchesService = $researchesService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $data = $this->service->findAll($params);

        $this->researchesService->saveResearch($request, 'documental');

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
        $this->authorize('role-documental');

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
        return $this->repository->find($id);
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
        $this->authorize('role-documental');

        return $this->service->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return array
     */
    public function destroy($id)
    {
        $this->authorize('role-documental');

        return $this->service->delete($id);
    }

    public function statistic()
    {
        return \ArqAdmin\Entities\Documento::statistic();
    }

    public function getRevisionHistory($id)
    {
        $this->authorize('role-documental');

        return $this->service->getRevisionHistory($id);
    }
}
