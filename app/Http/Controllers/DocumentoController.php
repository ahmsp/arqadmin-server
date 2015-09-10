<?php

namespace ArqAdmin\Http\Controllers;

use ArqAdmin\Http\Requests;
use ArqAdmin\Repositories\DocumentoRepository;
use ArqAdmin\Services\DocumentoService;
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
     * @param DocumentoRepository $repository
     * @param DocumentoService $service
     */
    public function __construct(DocumentoRepository $repository, DocumentoService $service)
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
        $data = $this->service->findAll($params);

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
        return $this->service->delete($id);
    }

    public function statistic()
    {
        return \ArqAdmin\Entities\Documento::statistic();
    }

}
