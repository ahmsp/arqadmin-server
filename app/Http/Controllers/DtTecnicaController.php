<?php

namespace ArqAdmin\Http\Controllers;

use ArqAdmin\Http\Requests;
use ArqAdmin\Repositories\DtTecnicaRepository;
use ArqAdmin\Services\DtTecnicaService;
use Illuminate\Http\Request;

class DtTecnicaController extends Controller
{
    /**
     * @var DtTecnicaRepository
     */
    protected $repository;

    /**
     * @var DtTecnicaService
     */
    protected $service;

    /**
     * @param DtTecnicaRepository $repository
     * @param DtTecnicaService $service
     */
    public function __construct(DtTecnicaRepository $repository, DtTecnicaService $service)
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
        $this->authorize('role-documental');

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
        $this->authorize('role-documental');

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
        $this->authorize('role-documental');

        return $this->service->delete($id);
    }
}
