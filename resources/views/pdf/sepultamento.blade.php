<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Acervo Termos de Sepultamento - Arquivo Histórico de São Paulo</title>
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
        <h2>Seleção de itens dos acervos de termos de sepultamento</h2>
        <p class="lead">Criado por {{ $userName }}, em {{ $date->format('d/m/Y à\s H\hi') }}</p>
    </div>

    <hr>

    <h3 class="sub-header">Itens do acervo</h3>
    @foreach($data as $item)
        <div class="table-wrap">
            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th width="210px">Nome:</th>
                    <th>{{ $item->sfm_nome or 'Não consta' }}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Registro ID:</td>
                    <td>{{ $item->id }}</td>
                </tr>
                @if ($item->sfm_idade)
                    <tr>
                        <td>Idade</td>
                        <td>{{ $item->sfm_idade }}</td>
                    </tr>
                @endif
                @if ($item->sfmNacionalidade)
                    <tr>
                        <td>Nacionalidade</td>
                        <td>{{ $item->sfmNacionalidade ? $item->sfmNacionalidade->nacionalidade : null }}</td>
                    </tr>
                @endif
                @if ($item->sfmNaturalidade)
                    <tr>
                        <td>Naturalidade</td>
                        <td>{{ $item->sfmNaturalidade ? $item->sfmNaturalidade->naturalidade : '' }}</td>
                    </tr>
                @endif
                @if ($item->sfmEstadocivil)
                    <tr>
                        <td>Estado civil</td>
                        <td>{{ $item->sfmEstadocivil ? $item->sfmEstadocivil->estadocivil : '' }}</td>
                    </tr>
                @endif
                @if ($item->sfm_conjuge)
                    <tr>
                        <td>Nome do Cônjuge</td>
                        <td>{{ $item->sfm_conjuge }}</td>
                    </tr>
                @endif
                @if ($item->sfm_pai)
                    <tr>
                        <td>Nome do Pai</td>
                        <td>{{ $item->sfm_pai }}</td>
                    </tr>
                @endif
                @if ($item->sfm_mae)
                    <tr>
                        <td>Nome da Mãe</td>
                        <td>{{ $item->sfm_mae }}</td>
                    </tr>
                @endif
                @if ($item->sfm_data_morte)
                    <tr>
                        <td>Data da Morte</td>
                        <td>{{ $item->sfm_data_morte }}</td>
                    </tr>
                @endif
                @if ($item->sfmCausamortis)
                    <tr>
                        <td>Causa Mortis</td>
                        <td>{{ $item->sfmCausamortis ? $item->sfmCausamortis->causamortis : '' }}</td>
                    </tr>
                @endif
                @if ($item->sfmCartorio)
                    <tr>
                        <td>Cartório</td>
                        <td>{{ $item->sfmCartorio ? $item->sfmCartorio->cartorio : '' }}</td>
                    </tr>
                @endif
                @if ($item->sfmCemiterio)
                    <tr>
                        <td>Cemitério</td>
                        <td>{{ $item->sfmCemiterio ? $item->sfmCemiterio->cemiterio : '' }}</td>
                    </tr>
                @endif
                @if ($item->sfm_sepult_localizacao)
                    <tr>
                        <td>Sepultamento Localização</td>
                        <td>{{ $item->sfm_sepult_localizacao }}</td>
                    </tr>
                @endif
                @if ($item->lc_acondicionamento_num)
                    <tr>
                        <td>Livro nº</td>
                        <td>{{ $item->lc_acondicionamento_num }}</td>
                    </tr>
                @endif
                @if ($item->lc_pagina)
                    <tr>
                        <td>Página</td>
                        <td>{{ $item->lc_pagina }}</td>
                    </tr>
                @endif
                @if ($item->notas)
                    <tr>
                        <td>Notas</td>
                        <td>{{ $item->notas }}</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <br>
        <p style="page-break-before: always;"></p>
    @endforeach
</div>
</body>
</html>