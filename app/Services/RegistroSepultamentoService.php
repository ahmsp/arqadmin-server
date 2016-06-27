<?php

namespace ArqAdmin\Services;


use ArqAdmin\Entities\User;
use ArqAdmin\Repositories\RegistroSepultamentoRepository;
use ArqAdmin\Validators\RegistroSepultamentoValidator;
use Carbon\Carbon;
use Illuminate\Container\Container as Application;
use Maatwebsite\Excel\Facades\Excel;

class RegistroSepultamentoService extends BaseService
{
    /**
     * @var DownloadService
     */
    private $downloadService;

    /**
     * FotografiaService constructor.
     * @param Application $app
     * @param DownloadService $downloadService
     * @param ImagesService $imagesService
     */
    public function __construct(Application $app, DownloadService $downloadService, ImagesService $imagesService)
    {
        parent::__construct($app);
        $this->downloadService = $downloadService;
        $this->imagesService = $imagesService;
    }

    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return RegistroSepultamentoRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return RegistroSepultamentoValidator::class;
    }


    public function findAll($params = [])
    {

        $result = $this->repository->findAllWhere($params);

        return $result;
    }


    /**
     * @param string $type Type template parameters: xls|csv|pdf
     * @return array
     */
    public function getDatasheetDownloadUrl($type)
    {
        if ($this->repository->countUserLikes() === 0) {
            abort('404', 'Nenhum dado encontrado');
        }

        $fileName = 'AHSP_Acervo_Sepultamentos_Selecionados_' . Carbon::now()->format('Y-m-d_His') . '.' . $type;

        $validation = $this->downloadService->generateValidation('sepultamento', $fileName);
        $urlDownload = url("datasheet/download/sepultamento/{$type}/{$validation->token}");

        return ['url_download' => $urlDownload];
    }

    /**
     * @param string $token
     * @return array
     */
    public function downloadPDF($token)
    {
        if (!$downloadRow = $this->downloadService->validateDatasheetDownload($token)) {
            abort('401', 'Link não encontrado ou expirado!');
        }

        $user = User::where('username', $downloadRow->username)->first();
        $data = $this->repository->findAllUserLikes($user->id);
        $date = Carbon::now();

        $this->downloadService->repository->update(['download_date' => $date], $downloadRow->id);

        return [
            'filename' => $downloadRow->file_name,
            'data' => $data,
            'date' => $date,
            'userName' => $user->name,
        ];
    }

    /**
     * @param string $type Type template parameters: xls|csv|pdf
     * @param string $token
     * @return array
     *
     */
    public function downloadDatasheet($type, $token)
    {
        if (!$downloadRow = $this->downloadService->validateDatasheetDownload($token)) {
            abort('401', 'Link não encontrado ou expirado!');
        }

        $userId = User::where('username', $downloadRow->username)->first()->id;
        $fileName = pathinfo($downloadRow->file_name, PATHINFO_FILENAME);

        $this->downloadService->repository->update(['download_date' => Carbon::now()], $downloadRow->id);

        $data = $this->formatSheet($this->repository->findAllUserLikes($userId));
        $this->exportExcel($fileName, $type, $data);
    }

    public function exportExcel($filename, $type, $data)
    {
        return Excel::create($filename, function ($excel) use ($data, $type) {

            $excel->setTitle('Acervo Termos de Sepultamento - AHSP');
            $excel->setCreator('ArqAdmin')->setCompany('Arquivo Histórico de São Paulo');
            $excel->setDescription('Seleção de itens do acervo de Termos de Sepultamento do AHSP');

            $excel->sheet('Sepultamento', function ($sheet) use ($data, $type) {
                if ($type == 'pdf') {
                    $sheet->setPaperSize(64); //A2
                }
                $sheet->fromArray($data['items']);
            });

        })->download($type);
    }

    public function formatSheet($data)
    {
        $items = [];
        foreach ($data as $item) {
            array_push($items, [
                'Registro ID' => $item->id,
                'Nome' => $item->sfm_nome,
                'Nacionalidade' => $item->sfmNacionalidade ? $item->sfmNacionalidade->nacionalidade : '',
                'Naturalidade' => $item->sfmNaturalidade ? $item->sfmNaturalidade->naturalidade : '',
                'Idade' => $item->sfm_idade,
                'Estado civil' => $item->sfmEstadocivil ? $item->sfmEstadocivil->estadocivil : '',
                'Nome do Cônjuge' => $item->sfm_conjuge,
                'Nome do Pai' => $item->sfm_pai,
                'Nome da Mãe' => $item->sfm_mae,
                'Data_morte' => $item->sfm_data_morte,
                'Causa Mortis' => $item->sfmCausamortis ? $item->sfmCausamortis->causamortis : '',
                'Cartório' => $item->sfmCartorio ? $item->sfmCartorio->cartorio : '',
                'Cemitério' => $item->sfmCemiterio ? $item->sfmCemiterio->cemiterio : '',
                'Sepultamento Localizacao' => $item->sfm_sepult_localizacao,
                'Sala' => $item->lcSala ? $item->lcSala->sala : '',
                'Móvel' => $item->lcMovel ? $item->lcMovel->movel : '',
                'Móvel nº' => $item->lc_movel_num,
                'Compartimento' => $item->lcCompartimento ? $item->lcCompartimento->compartimento : '',
                'Compartimento nº' => $item->lc_compartimento_num,
                'Acondicionamento' => $item->lcAcondicionamento ? $item->lcAcondicionamento->acondicionamento : '',
                'Acondicionamento nº' => $item->lc_acondicionamento_num,
                'Página' => $item->lc_pagina,
                'Notas' => $item->notas,
                'Imagem' => $item->imagem,
            ]);
        }

        return [
            'items' => $items
        ];
    }
}
