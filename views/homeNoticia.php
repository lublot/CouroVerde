<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!--Codificação dos caracteres: UTF-8-->
    <meta charset="utf-8" />
    <!--Descrição da página: Sertour-->
    <meta name="description" content="Setour" />
    <!--Regulando a visão da tela para a largura relativa à tela utilizada-->
    <meta name=viewport content="width=device-width, initial-scale=1" />

    <title>Lista de Notícias</title>

    <!--Importação do CSS do Bootstrap, Bootflat e o pessoal (Estilos)-->
    <?php $this->carregarDependencias()?>
    <link rel="stylesheet" href=<?php $this->path("assets/css/adm.css")?>>
    <script src=<?php $this->path("assets/js/inicioNoticia-script.js")?>></script>

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
                <h4 class="text-center">Lista de Notícias</h4>
            </div>
            <!--Fim do título da caixa-->

            <!-- Contorno -->
            <div id="contorno">
                <a href="#" class="direita">Ajuda  <span></span></a>
                <!-- Caixa interna -->
                <section id="caixa">

                    <!-- Inicio da caixa de busca-->
                    <div class="row busca">

                        <!-- Tamanho e posição do input de busca -->
                        <div class="col-sm-12">

                            <!-- Input de busca  -->

                            <div class="search-only form-search">
                                <i class="search-icon fa fa-search"></i>
                                <input type="text" class="form-control search-query input-sm" placeholder="Busca" id="campoBusca" style="border-radius: 30px;" />
                            </div>

                            <!-- FIM Tamanho e posição do input de busca -->
                        </div>

                        <!-- FIM da caixa de busca -->
                    </div>




                    <!-- Inicio da galeria -->
                    <div class="row" align="center" id="resposta">
                        
                    </div>

                </section>

                <!-- FIM do Contorno -->
            </div>

        </div>

    </div>
    <?php $this->carregarRodape()?>

</body>

</html>