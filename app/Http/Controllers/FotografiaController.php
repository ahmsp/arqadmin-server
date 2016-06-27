<?php

namespace ArqAdmin\Http\Controllers;

use ArqAdmin\Http\Requests;
use ArqAdmin\Repositories\FotografiaRepository;
use ArqAdmin\Services\FotografiaService;
use ArqAdmin\Services\ResearchesService;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class FotografiaController extends Controller
{
    /**
     * @var FotografiaRepository
     */
    protected $repository;

    /**
     * @var FotografiaService
     */
    protected $service;
    /**
     * @var ResearchesService
     */
    private $researchesService;

    /**
     * @param FotografiaRepository $repository
     * @param FotografiaService $service
     * @param ResearchesService $researchesService
     */
    public function __construct(FotografiaRepository $repository, FotografiaService $service,
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
        $data = $this->repository->findAllWhere($params);

        $this->researchesService->saveResearch($request, 'fotografico');

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
        $this->authorize('role-fotografico');

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
        $this->authorize('role-fotografico');

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
        $this->authorize('role-fotografico');

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
        $this->authorize('role-fotografico');

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
        $this->authorize('role-fotografico');

        return $this->service->upload($request, $id);
    }

    public function getRevisionHistory($id)
    {
        $this->authorize('role-fotografico');

        return $this->service->getRevisionHistory($id);
    }

    public function like($id)
    {
        return $this->repository->like($id);
    }

    public function removeUserLikes()
    {
        return $this->repository->removeUserLikes();
    }

    // Type template: xls|csv|pdf
    public function getDatasheetDownloadUrl($type)
    {
        $datasheet = $this->service->getDatasheetDownloadUrl($type);

        return ['url_download' => $datasheet['url_download']];
    }

    // Size template: xls|csv|pdf
    public function downloadFavorites($type, $token)
    {
        if ($type == 'pdf') {
            $data = $this->service->downloadPDF($token);

//            return view('pdf.documental', [
//                'data' => $data['data'],
//                'userName' => $data['userName'],
//                'date' => $data['date']
//            ]);

            $pdf = PDF::loadView('pdf.fotografico', [
                'data' => $data['data'],
                'userName' => $data['userName'],
                'date' => $data['date']
            ]);

            return $pdf->download($data['filename']);
//            return $pdf->stream($data['filename']);

        } else {
            if (!$datasheet = $this->service->downloadDatasheet($type, $token)) {
                abort(404, 'Link não encontrado ou expirado!');
            }
        }
    }

}
