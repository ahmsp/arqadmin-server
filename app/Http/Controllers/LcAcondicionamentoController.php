<?php

namespace ArqAdmin\Http\Controllers;

use ArqAdmin\Entities\LcAcondicionamento;
use ArqAdmin\Http\Requests;
use ArqAdmin\Repositories\LcAcondicionamentoRepository;
use ArqAdmin\Services\LcAcondicionamentoService;
use Illuminate\Http\Request;

class LcAcondicionamentoController extends Controller
{
    /**
     * @var LcAcondicionamentoRepository
     */
    protected $repository;

    /**
     * @var LcAcondicionamentoService
     */
    protected $service;

    /**
     * @param LcAcondicionamentoRepository $repository
     * @param LcAcondicionamentoService $service
     */
    public function __construct(LcAcondicionamentoRepository $repository, LcAcondicionamentoService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        $data = $this->repository->paginate(500);
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
        $this->authorize('edit', LcAcondicionamento::class);

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
        $this->authorize('edit', LcAcondicionamento::class);

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
        $this->authorize('edit', LcAcondicionamento::class);

        return $this->service->delete($id);
    }
}
