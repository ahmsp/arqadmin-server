<?php

namespace ArqAdmin\Http\Controllers;

use ArqAdmin\Repositories\GrupoRepository;
use ArqAdmin\Services\GrupoService;
use Illuminate\Http\Request;

use ArqAdmin\Http\Requests;

/**
 * Class GrupoController
 * @package ArqAdmin\Http\Controllers
 */
class GrupoController extends Controller
{
    /**
     * @var GrupoRepository
     */
    protected $repository;

    /**
     * @var GrupoService
     */
    protected $service;

    /**
     * @param GrupoRepository $repository
     * @param GrupoService $service
     */
    public function __construct(GrupoRepository $repository, GrupoService $service)
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