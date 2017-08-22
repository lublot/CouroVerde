<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!--Codificação dos caracteres: UTF-8-->
    <meta charset="utf-8" />
    <!--Descrição da página: Sertour-->
    <meta name="description" content="Setour" />
    <!--Regulando a visão da tela para a largura relativa à tela utilizada-->
    <meta name=viewport content="width=device-width, initial-scale=1" />

    <title>Relatório do Sistema</title>

    
    <?php $this->carregarDependencias()?>
    <link rel="stylesheet" href=<?php $this->path("assets/css/adm.css")?>>
    <script src=<?php $this->path('assets/js/relatorioSistema-script.js')?>> </script>
</head>

<body style="background-color: rgb(241, 242, 246);">

    <?php $this->carregarCabecalho()?>
    <div class="container">

        <!-- Painel -->
        <div class="col-md-3 col-lg-3">
            <?php $this->carregarPainel()?>
        </div>

        <div class="col-md-9 col-lg-9">

            <!--Título da caixa-->
            <div id="titulo">
                <h4 class="text-center">Relatório do sistema</h4>
            </div>
            <!--Fim do título da caixa-->


            <!-- Início da tabela -->
            <div id="pagina"></div>

        </div>
    </div>
    </div>

    <?php $this->carregarRodape()?>
</body>

<!-- Footer -->
