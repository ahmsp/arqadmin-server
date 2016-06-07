<?php

namespace ArqAdmin\Http\Controllers;

use ArqAdmin\Entities\DesenhoTecnico;
use ArqAdmin\Entities\Documento;
use ArqAdmin\Entities\Fotografia;
use ArqAdmin\Entities\RegistroSepultamento;
use ArqAdmin\Http\Requests;
use Illuminate\Support\Facades\DB;

class Statistics extends Controller
{
    public function getTotalItems()
    {

        // todo: to refactor

        $documental = Documento::count();
        $fotografico = Fotografia::count();
        $sepultamento = RegistroSepultamento::count();

        $fundoPmspFotografico = Fotografia::where('ft_fundo_id', 9)->count();

        $fundosCount = Documento::join('fundo', 'documento.fundo_id', '=', 'fundo.id')
            ->select(DB::raw('count(*) as count, fundo.fundo_nome, fundo.id'))
            ->whereIn('fundo.id', [3, 4, 22])
            ->groupBy('documento.fundo_id')
            ->orderBy('count', 'desc')
            ->get();

        $fundos = [];
        $totalFundos = 0;
        foreach ($fundosCount as $fundo) {

            if ($fundo->id === 3) {
                $fundoPmspCount = $fundo->count + $sepultamento + $fundoPmspFotografico;
            }

            array_push($fundos, [
                'item' => $fundo->fundo_nome,
                'total' => $fundo->id === 3 ? $fundoPmspCount : $fundo->count
            ]);

            $totalFundos += $fundo->count;
        }

        array_push($fundos, [
                'item' => 'Outros',
                'total' => $documental - $totalFundos + ($fotografico - $fundoPmspFotografico)
            ]
        );

        $subfundosCount = Documento::join('subfundo', 'documento.subfundo_id', '=', 'subfundo.id')
            ->select(DB::raw('count(*) as count, subfundo.subfundo_nome'))
            ->whereIn('subfundo.id', [9, 14, 22])
            ->groupBy('documento.subfundo_id')
            ->orderBy('count', 'desc')
            ->get();

        $subfundos = [];
        $totalSubfundos = 0;
        foreach ($subfundosCount as $subfundo) {
            array_push($subfundos, [
                'item' => $subfundo->subfundo_nome,
                'total' => $subfundo->count
            ]);

            $totalSubfundos += $subfundo->count;
        }

        array_unshift($subfundos, [
            'item' => 'Serviço Funerário Municipal <br>(Termos de Sepultamento)',
            'total' => $sepultamento
        ]);

        array_push($subfundos, [
                'item' => 'Outros',
                'total' => $documental - $totalSubfundos + ($fotografico - $fundoPmspFotografico)
            ]
        );


        $dtImagesCount = DesenhoTecnico::where('acervo_tipo', 'cartografico')
            ->where('arquivo_original', '<>', '')
            ->whereNotNull('arquivo_original')
            ->count();


        $fotograficoImagesCount = Fotografia::whereNotNull('imagem_original')
            ->where('imagem_original', '<>', '')
            ->count();


        $totals = [
            'total' => $documental + $fotografico + $sepultamento,
            'documental' => $documental,
            'fotografico' => $fotografico,
            'images_total' => $dtImagesCount + $fotograficoImagesCount,
            'sepultamento' => $sepultamento,
            'fundos' => $fundos,
            'subfundos' => $subfundos
        ];

        return $totals;
    }
}
