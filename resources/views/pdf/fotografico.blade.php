<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Acervo Fotográfico - Arquivo Histórico de São Paulo</title>
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
        <h2>Seleção de itens do acervo fotográfico</h2>
        <p class="lead">Criado por {{ $userName }}, em {{ $date->format('d/m/Y à\s H\hi') }}</p>
    </div>

    <hr>

    <h3 class="sub-header">Itens do acervo</h3>
    @foreach($data as $item)
        <div class="table-wrap">
            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th width="210px">Identificação:</th>
                    <th>{{ $item->identificacao or 'Não consta' }}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Imagem ID:</td>
                    <td>{{ $item->id }}</td>
                </tr>
                @if ($item->ftFundo)
                    <tr>
                        <td>Fundo:</td>
                        <td>{{ $item->ftFundo ? $item->ftFundo->fundo : null }}</td>
                    </tr>
                @endif
                @if ($item->ftGrupo)
                    <tr>
                        <td>Grupo:</td>
                        <td>{{ $item->ftGrupo ? $item->ftGrupo->grupo : null }}</td>
                    </tr>
                @endif
                @if ($item->ftSerie)
                    <tr>
                        <td>Série:</td>
                        <td>{{ $item->ftSerie ? $item->ftSerie->serie : null }}</td>
                    </tr>
                @endif
                @if ($item->ftTipologia)
                    <tr>
                        <td>Sub-série:</td>
                        <td>{{ $item->ftTipologia ? $item->ftTipologia->tipologia : null }}</td>
                    </tr>
                @endif
                @if ($item->data_imagem)
                    <tr>
                        <td>Data da imagem:</td>
                        <td>{{ $item->data_imagem }}</td>
                    </tr>
                @endif
                @if ($item->autoria)
                    <tr>
                        <td>Autoria:</td>
                        <td>{{ $item->autoria }}</td>
                    </tr>
                @endif


                @if ($item->imagem_identificacao)
                    <tr>
                        <td>Identificação da Imagem:</td>
                        <td>{{ $item->imagem_identificacao }}</td>
                    </tr>
                @endif
                @if ($item->bairro)
                    <tr>
                        <td>Bairro:</td>
                        <td>{{ $item->bairro }}</td>
                    </tr>
                @endif
                @if ($item->assunto_geral)
                    <tr>
                        <td>Assunto Geral:</td>
                        <td>{{ $item->assunto_geral }}</td>
                    </tr>
                @endif
                @if ($item->titulo)
                    <tr>
                        <td>Título:</td>
                        <td>{{ $item->titulo }}</td>
                    </tr>
                @endif
                @if ($item->identificacao)
                    <tr>
                        <td>Identificação:</td>
                        <td>{{ $item->identificacao }}</td>
                    </tr>
                @endif
                @if ($item->assunto_1)
                    <tr>
                        <td>Assunto 1:</td>
                        <td>{{ $item->assunto_1 }}</td>
                    </tr>
                @endif
                @if ($item->assunto_2)
                    <tr>
                        <td>Assunto 2:</td>
                        <td>{{ $item->assunto_2 }}</td>
                    </tr>
                @endif
                @if ($item->assunto_3)
                    <tr>
                        <td>Assunto 3:</td>
                        <td>{{ $item->assunto_3 }}</td>
                    </tr>
                @endif
                @if ($item->ftCromia)
                    <tr>
                        <td>Cromia:</td>
                        <td>{{ $item->ftCromia ? $item->ftCromia->cromia : null }}</td>
                    </tr>
                @endif
                @if ($item->formato)
                    <tr>
                        <td>Formato:</td>
                        <td>{{ $item->formato }}</td>
                    </tr>
                @endif
                @if ($item->ftCategoria)
                    <tr>
                        <td>Categoria:</td>
                        <td>{{ $item->ftCategoria ? $item->ftCategoria->categoria : null }}</td>
                    </tr>
                @endif
                @if ($item->ftCampo)
                    <tr>
                        <td>Campo:</td>
                        <td>{{ $item->ftCampo ? $item->ftCampo->campo : null}}</td>
                    </tr>
                @endif
                @if ($item->tipo)
                    <tr>
                        <td>Tipo:</td>
                        <td>{{ $item->tipo }}</td>
                    </tr>
                @endif
                @if ($item->ft_ambiente)
                    <tr>
                        <td>Ambiente:</td>
                        <td>{{ $item->ft_ambiente }}</td>
                    </tr>
                @endif
                @if ($item->enquadramento)
                    <tr>
                        <td>Enquadramento:</td>
                        <td>{{ $item->enquadramento }}</td>
                    </tr>
                @endif
                @if ($item->inscricao)
                    <tr>
                        <td>Inscrição:</td>
                        <td>{{ $item->inscricao }}</td>
                    </tr>
                @endif
                @if ($item->texto_inscricao)
                    <tr>
                        <td>Texto Inscrição:</td>
                        <td>{{ $item->texto_inscricao }}</td>
                    </tr>
                @endif
                @if ($item->imagem_original)
                    <tr>
                        <td>arquivo Original:</td>
                        <td>{{ $item->imagem_original }}</td>
                    </tr>
                @endif
                </tbody>
            </table>
            {{--<p style="page-break-before: always;">Podemos romper la página en cualquier momento...</p>--}}
        </div>
        <br>
    @endforeach
</div>
</body>
</html>