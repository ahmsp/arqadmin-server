<?php

namespace ArqAdmin\Services;

use ArqAdmin\Entities\User;
use ArqAdmin\Repositories\DocumentoRepository;
use ArqAdmin\Validators\DocumentoValidator;
use Carbon\Carbon;
use Illuminate\Container\Container as Application;
use Maatwebsite\Excel\Facades\Excel;

class DocumentoService extends BaseService
{
    /**
     * @var DownloadService
     */
    private $downloadService;

    /**
     * FotografiaService constructor.
     * @param Application $app
     * @param DownloadService $downloadService
     */
    public function __construct(Application $app, DownloadService $downloadService)
    {
        parent::__construct($app);

        $this->downloadService = $downloadService;
    }

    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return DocumentoRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return DocumentoValidator::class;
    }


    public function findAll($params = [])
    {
        //$test = serialize($params);
        //dd(unserialize($test));

        //dd($params);
        //dd(serialize($params));

        return $this->repository->findAllWhere($params);
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

        $fileName = 'AHSP_Acervo_Documental_Selecionados_' . Carbon::now()->format('Y-m-d_His') . '.' . $type;

        $validation = $this->downloadService->generateValidation('documental', $fileName);
        $urlDownload = url("datasheet/download/documental/{$type}/{$validation->token}");

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

            $excel->setTitle('Acervo Documental - AHSP');
            $excel->setCreator('ArqAdmin')->setCompany('Arquivo Histórico de São Paulo');
            $excel->setDescription('Seleção de itens do acervo documental do AHSP');

            $excel->sheet('Documentos', function ($sheet) use ($data, $type) {
                if ($type == 'pdf') {
                    $sheet->setPaperSize(64); //A2
                }
                $sheet->fromArray($data['doc']);
            });

            $excel->sheet('Imagens relacionadas', function ($sheet) use ($data) {
                $sheet->fromArray($data['images']);
            });
        })->download($type);
    }

    public function formatSheet($data)
    {
        $doc = [];
        $images = [];
        foreach ($data as $item) {
            array_push($doc, [
                'Documento ID' => $item->id,
                'Fundo' => $item->fundo ? $item->fundo->fundo_nome : '',
                'Sub-fundo' => $item->subfundo ? $item->subfundo->subfundo_nome : '',
                'Grupo' => $item->grupo ? $item->grupo->grupo_nome : '',
                'Sub-grupo' => $item->subgrupo ? $item->subgrupo->subgrupo_nome : '',
                'Série' => $item->serie ? $item->serie->serie_nome : '',
                'Sub-série' => $item->subserie ? $item->subserie->subserie_nome : '',
                'Dossiê' => $item->dossie ? $item->dossie->dossie_nome : '',
                'Especie Documental' => $item->especieDocumental ? $item->especieDocumental->especiedocumental_nome : '',
                'Notacao Pré-existente' => $item->notacao_preexistente,
                'Notação' => $item->notacao,
                'Ano' => $item->ano,
                'Data' => $item->data_doc,
                'Processo nº' => $item->processo_num,
                'Quantidade Documentos' => $item->quantidade_doc,
                'Conservação' => $item->conservacao ? $item->conservacao->conservacao_estado : '',
                'Interessado' => $item->interessado,
                'Assunto' => $item->assunto,
                'Notas' => $item->notas,
                'Uso' => $item->dtUso ? $item->dtUso->uso : '',
                'Endereco' => $item->dt_endereco,
                'End. Complemento' => $item->dt_end_complemento,
                'Endereço Atual' => $item->dt_endereco_atual,
                'End. atual Complemento' => $item->dt_endatual_complemento,
                'Proprietário' => $item->dt_proprietario,
                'Autor' => $item->dt_autor,
                'Construtor' => $item->dt_construtor,
                'Notas Imagem' => $item->dt_notas,
            ]);

            foreach ($item->desenhosTecnicos as $img) {
                array_push($images, [
                    'Documento ID' => $img->documento_id,
                    'Imagem ID' => $img->id,
                    'Acervo Tipo' => $img->acervo_tipo,
                    'Notação' => $img->notacao,
                    'Prancha nº' => $img->prancha_num,
                    'Original nº' => $img->original_num,
                    'Desenho Data' => $img->desenho_data,
                    'Descrição' => $img->descricao,
                    'Desenhista' => $img->desenhista,
                    'Original' => $img->original,
                    'Cópia' => $img->copia,
                    'Tipo' => $img->dtTipo ? $img->dtTipo->dt_tipo_id : '',
                    'Dimensão' => $img->dimensao,
                    'Suporte' => $img->dtSuporte ? $img->dtSuporte->dt_suporte_id : '',
                    'Escala' => $img->dtEscala ? $img->dtEscala->dt_escala_id : '',
                    'Técnica' => $img->dtTecnica ? $img->dtTecnica->dt_tecnica_id : '',
                    'Notas' => $img->notas,
                    'Conservação' => $img->dtConservacao ? $img->dtConservacao->dt_conservacao_id : '',
                    'Arquivo original' => $img->arquivo_original,
                ]);
            }

        }

        return [
            'doc' => $doc,
            'images' => $images
        ];
    }

//    public function pregReplaceArray($pattern, $replacement, $subject, $limit=-1)
//    {
//        if (is_array($subject)) {
//            foreach ($subject as &$value){
//                $value = $this->pregReplaceArray($pattern, $replacement, $value, $limit);
//            }
//            return $subject;
//        } else {
//            return preg_replace($pattern, $replacement, $subject, $limit);
//        }
//    }

}