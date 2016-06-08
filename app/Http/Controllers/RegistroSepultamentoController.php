<?php

namespace ArqAdmin\Http\Controllers;

use ArqAdmin\Http\Requests;
use ArqAdmin\Repositories\RegistroSepultamentoRepository;
use ArqAdmin\Services\RegistroSepultamentoService;
use ArqAdmin\Services\ResearchesService;
use Illuminate\Http\Request;

class RegistroSepultamentoController extends Controller
{
    /**
     * @var RegistroSepultamentoRepository
     */
    protected $repository;

    /**
     * @var RegistroSepultamentoService
     */
    protected $service;
    /**
     * @var ResearchesService
     */
    private $researchesService;

    /**
     * @param RegistroSepultamentoRepository $repository
     * @param RegistroSepultamentoService $service
     * @param ResearchesService $researchesService
     */
    public function __construct(RegistroSepultamentoRepository $repository, RegistroSepultamentoService $service,
                                ResearchesService $researchesService)
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->researchesService = $researchesService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $data = $this->service->findAll($params);

        $this->researchesService->saveResearch($request, 'sepultamento');

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return array
     */
    public function store(Request $request)
    {
        $this->authorize('role-sepultamento');

        return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return array
     */
    public function show($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return array
     */
    public function update(Request $request, $id)
    {
        $this->authorize('role-sepultamento');

        return $this->service->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return array
     */
    public function destroy($id)
    {
        $this->authorize('role-sepultamento');

        return $this->service->delete($id);
    }

    public function getRevisionHistory($id)
    {
        return $this->service->getRevisionHistory($id);
    }
}
