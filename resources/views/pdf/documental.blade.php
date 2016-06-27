<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Acervo Documental - Arquivo Histórico de São Paulo</title>
    {{--<link href="css/pdf_curstom_bootstrap/css/bootstrap.min.css" rel="stylesheet">--}}
    <link rel="stylesheet" type="text/css" href="css/pdf.css">
</head>
<body>

<header>
    <h1>Acervo - Arquivo Histórico de São Paulo</h1>
    <h2>arquivohistorico.sp.gov.br</h2>
</header>
<footer>
    <table>
        <tr>
            <td>
                <p class="izq">
                    Seleção do acervo
                </p>
            </td>
            <td>
                <p class="page">
                    Página
                </p>
            </td>
        </tr>
    </table>
</footer>


<div class="container">
    <div class="page-header">
        <h2>Seleção de itens dos acervos textual e cartográfico</h2>
        <p class="lead">Criado por {{ $userName }}, em {{ $date->format('d/m/Y à\s H\hi') }}</p>
    </div>

    <hr>

    <h3 class="sub-header">Itens do acervo</h3>
    @foreach($data as $item)
        <div class="table-wrap">
            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th width="210px">Assunto:</th>
                    <th>{{ $item->assunto or 'Não consta' }}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Documento ID:</td>
                    <td>{{ $item->id }}</td>
                </tr>
                @if ($item->fundo)
                    <tr>
                        <td>Fundo:</td>
                        <td>{{ $item->fundo ? $item->fundo->fundo_nome : null }}</td>
                    </tr>
                @endif
                @if ($item->subfundo)
                    <tr>
                        <td>Sub-fundo:</td>
                        <td>{{ $item->subfundo ? $item->subfundo->subfundo_nome : null }}</td>
                    </tr>
                @endif
                @if ($item->grupo)
                    <tr>
                        <td>Grupo:</td>
                        <td>{{ $item->grupo ? $item->grupo->grupo_nome : null }}</td>
                    </tr>
                @endif
                @if ($item->subgrupo)
                    <tr>
                        <td>Sub-grupo:</td>
                        <td>{{ $item->subgrupo ? $item->subgrupo->subgrupo_nome : null }}</td>
                    </tr>
                @endif
                @if ($item->serie)
                    <tr>
                        <td>Série:</td>
                        <td>{{ $item->serie ? $item->serie->serie_nome : null }}</td>
                    </tr>
                @endif
                @if ($item->subserie)
                    <tr>
                        <td>Sub-série:</td>
                        <td>{{ $item->subserie ? $item->subserie->subserie_nome : null }}</td>
                    </tr>
                @endif
                @if ($item->dossie)
                    <tr>
                        <td>Dossiê:</td>
                        <td>{{ $item->dossie ? $item->dossie->dossie_nome : null }}</td>
                    </tr>
                @endif
                @if ($item->especieDocumental)
                    <tr>
                        <td>Especie Documental:</td>
                        <td>{{ $item->especieDocumental ? $item->especieDocumental->especiedocumental_nome : null }}</td>
                    </tr>
                @endif
                @if ($item->notacao_preexistente)
                    <tr>
                        <td>Notacao Pré-existente:</td>
                        <td>{{ $item->notacao_preexistente }}</td>
                    </tr>
                @endif
                @if ($item->notacao)
                    <tr>
                        <td>Notação:</td>
                        <td>{{ $item->notacao}}</td>
                    </tr>
                @endif
                @if ($item->ano)
                    <tr>
                        <td>Ano:</td>
                        <td>{{ $item->ano }}</td>
                    </tr>
                @endif
                @if ($item->data_doc)
                    <tr>
                        <td>Data:</td>
                        <td>{{ $item->data_doc}}</td>
                    </tr>
                @endif
                @if ($item->processo_num)
                    <tr>
                        <td>Processo nº:</td>
                        <td>{{ $item->processo_num }}</td>
                    </tr>
                @endif
                @if ($item->interessado)
                    <tr>
                        <td>Interessado:</td>
                        <td>{{ $item->interessado}}</td>
                    </tr>
                @endif
                @if ($item->assunto)
                    <tr>
                        <td>Assunto:</td>
                        <td>{{ $item->assunto }}</td>
                    </tr>
                @endif
                @if ($item->notas)
                    <tr>
                        <td>Notas:</td>
                        <td>{{ $item->notas}}</td>
                    </tr>
                @endif
                @if ($item->dtUso)
                    <tr>
                        <td>Uso:</td>
                        <td>{{ $item->dtUso ? $item->dtUso->uso : null }}</td>
                    </tr>
                @endif
                @if ($item->dt_endereco)
                    <tr>
                        <td>Endereco:</td>
                        <td>{{ $item->dt_endereco}}</td>
                    </tr>
                    <tr>
                        <td>End. Complemento:</td>
                        <td>{{ $item->dt_end_complemento }}</td>
                    </tr>
                @endif
                @if ($item->dt_endereco_atual)
                    <tr>
                        <td>Endereço Atual:</td>
                        <td>{{ $item->dt_endereco_atual}}</td>
                    </tr>
                    <tr>
                        <td>End. atual Complemento:</td>
                        <td>{{ $item->dt_endatual_complemento }}</td>
                    </tr>
                @endif
                @if ($item->dt_proprietario)
                    <tr>
                        <td>Proprietário:</td>
                        <td>{{ $item->dt_proprietario}}</td>
                    </tr>
                @endif
                @if ($item->dt_autor)
                    <tr>
                        <td>Autor:</td>
                        <td>{{ $item->dt_autor }}</td>
                    </tr>
                @endif
                @if ($item->dt_construtor)
                    <tr>
                        <td>Construtor:</td>
                        <td>{{ $item->dt_construtor}}</td>
                    </tr>
                @endif
                @if ($item->dt_notas)
                    <tr>
                        <td>Notas Imagem:</td>
                        <td>{{ $item->dt_notas }}</td>
                    </tr>
                @endif
                </tbody>
            </table>

            @if (count($item->desenhosTecnicos) > 0)
                <h3 class="sub-header sub-table">Imagens relacionadas ({{ count($item->desenhosTecnicos) }} imagens)</h3>
            @endif

            @foreach($item->desenhosTecnicos as $img)
                <table class="table table-bordered table-condensed">
                    <tr class="tr-head">
                        <td width="200px">Imagem ID:</td>
                        <td>{{ $img->id }}</td>
                    </tr>
                    @if ($img->acervo_tipo)
                        <tr>
                            <td>Acervo Tipo:</td>
                            <td>{{ $img->acervo_tipo }}</td>
                        </tr>
                    @endif
                    @if ($img->notacao)
                        <tr>
                            <td>Notação:</td>
                            <td>{{ $img->notacao }}</td>
                        </tr>
                    @endif
                    @if ($img->prancha_num)
                        <tr>
                            <td>Prancha nº:</td>
                            <td>{{ $img->prancha_num }}</td>
                        </tr>
                    @endif
                    @if ($img->original_num)
                        <tr>
                            <td>Original nº:</td>
                            <td>{{ $img->original_num }}</td>
                        </tr>
                    @endif
                    @if ($img->desenho_data)
                        <tr>
                            <td>Desenho Data:</td>
                            <td>{{ $img->desenho_data }}</td>
                        </tr>
                    @endif
                    @if ($img->descricao)
                        <tr>
                            <td>Descrição:</td>
                            <td>{{ $img->descricao }}</td>
                        </tr>
                    @endif
                    @if ($img->desenhista)
                        <tr>
                            <td>Desenhista:</td>
                            <td>{{ $img->desenhista }}</td>
                        </tr>
                    @endif
                    @if ($img->original)
                        <tr>
                            <td>Original:</td>
                            <td>{{ $img->original }}</td>
                        </tr>
                    @endif
                    @if ($img->copia)
                        <tr>
                            <td>Cópia:</td>
                            <td>{{ $img->copia }}</td>
                        </tr>
                    @endif
                    @if ($img->dtTipo)
                        <tr>
                            <td>Tipo:</td>
                            <td>{{ $img->dtTipo ? $img->dtTipo->dt_tipo_id : null }}</td>
                        </tr>
                    @endif
                    @if ($img->dimensao)
                        <tr>
                            <td>Dimensão:</td>
                            <td>{{ $img->dimensao }}</td>
                        </tr>
                    @endif
                    @if ($img->dtSuporte)
                        <tr>
                            <td>Suporte:</td>
                            <td>{{ $img->dtSuporte ? $img->dtSuporte->dt_suporte_id : null }}</td>
                        </tr>
                    @endif
                    @if ($img->dtEscala)
                        <tr>
                            <td>Escala:</td>
                            <td>{{ $img->dtEscala ? $img->dtEscala->dt_escala_id : null }}</td>
                        </tr>
                    @endif
                    @if ($img->dtTecnica)
                        <tr>
                            <td>Técnica:</td>
                            <td>{{ $img->dtTecnica ? $img->dtTecnica->dt_tecnica_id : null }}</td>
                        </tr>
                    @endif
                    @if ($img->notas)
                        <tr>
                            <td>Notas:</td>
                            <td>{{ $img->notas }}</td>
                        </tr>
                    @endif
                    @if ($img->dtConservacao)
                        <tr>
                            <td>Conservação:</td>
                            <td>{{ $img->dtConservacao ? $img->dtConservacao->dt_conservacao_id : null }}</td>
                        </tr>
                    @endif
                    @if ($img->arquivo_original)
                        <tr>
                            <td>Arquivo original:</td>
                            <td>{{ $img->arquivo_original }}</td>
                        </tr>
                    @endif
                </table>
            @endforeach

            {{--<p style="page-break-before: always;">Podemos romper la página en cualquier momento...</p>--}}
        </div>

        <br>
    @endforeach
</div>
</body>
</html>