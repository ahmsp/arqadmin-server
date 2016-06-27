<?php

namespace ArqAdmin\Http\Controllers;

use ArqAdmin\Http\Requests;
use ArqAdmin\Repositories\DocumentoRepository;
use ArqAdmin\Services\DocumentoService;
use ArqAdmin\Services\ResearchesService;
use Barryvdh\DomPDF\Facade as PDF;
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

            $pdf = PDF::loadView('pdf.documental', [
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
