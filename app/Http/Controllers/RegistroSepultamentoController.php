<?php

namespace ArqAdmin\Http\Controllers;

use ArqAdmin\Http\Requests;
use ArqAdmin\Repositories\RegistroSepultamentoRepository;
use ArqAdmin\Services\RegistroSepultamentoService;
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
     * @param RegistroSepultamentoRepository $repository
     * @param RegistroSepultamentoService $service
     */
    public function __construct(RegistroSepultamentoRepository $repository, RegistroSepultamentoService $service)
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
}
