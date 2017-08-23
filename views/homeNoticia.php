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
                <a href="#ajudanoticia" data-toggle="modal" class="direita">Ajuda  <span></span></a>
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

    <div>
        <div class="modal fade" id="ajudanoticia" role="dialog">

            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Tiítulo do modal -->
                    <div class="modal-header">
                        <h2 style="margin-bottom: 1px;">Suporte ao usuário - Notícia</h2>
                        <!-- Corpo do modal -->
                        <div class="modal-body">
                            <!-- Início da lista de tópicos -->
                            <div id="accordion" role="tablist" aria-multiselectable="true">

                                <!-- Novo tópico -->
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingOne">
                                        <!-- Nome do tópico -->
                                        <h4 class="mb-0">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            Como inserir uma nova notícia no site?
                                        </a>
                                        </h4>
                                    </div>

                                    <!-- Corpo do tópico -->
                                    <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="card-block">
                                            <ol>
                                                <li>Na barra lateral esquerda, clique em <strong>notícias</strong> e em seguida
                                                    em <strong>cadastrar notícia.</strong></li>
                                                <li>Escolha uma imagem ilustrativa para a notícia clicando em <img src=<?php $this->path("assets/images/upload.png")?> style="width: 18%; height: 18%"
                                                    /img></li>
                                                <li>Insira o título, subtítulo e o corpo de sua notícia</li>
                                                <li>clique em <img src=<?php $this->path("assets/images/cadastrar.png")?> style="width: 18%; height: 18%" /img> para salvar a notícia</li>
                                            </ol>

                                        </div>
                                    </div>
                                </div>

                                <!-- Novo tópico -->
                                <div class="card">
                                    <!-- Nome do tópico -->
                                    <div class="card-header" role="tab" id="headingTwo">
                                        <h4 class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Como alterar as informações de uma notícia?
                                        </a>
                                        </h4>
                                    </div>
                                    <!-- Corpo do tópico -->
                                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                        <div class="card-block">
                                            <ol>
                                                <li>Na barra lateral esquerda, clique em <strong>notícias</strong> e em seguida
                                                    em <strong>gerenciar notícias</strong></li>
                                                <li>Selecione a notícia cujas informações serão alteradas</li>
                                                <li>Clique em <strong>pronto</strong> para salvar suas alterações</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                                <!-- Novo tópico -->
                                <div class="card">
                                    <!-- Nome do tópico -->
                                    <div class="card-header" role="tab" id="headingThree">
                                        <h4 class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Como remover uma notícia?
                                        </a>
                                        </h4>
                                    </div>
                                    <!-- Corpo do tópico -->
                                    <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
                                        <div class="card-block">

                                            <ol>
                                                <li>Na barra lateral esquerda, clique em <strong>notícias</strong> e em seguida
                                                    em <strong>gerenciar notícias</strong></li>
                                                <li>Selecione a notícia que você deseja excluir</li>
                                                <li>.</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- Fim da lista de tópicos -->

                        </div>

                        <!-- Botão de fechar -->
                        <div class="modal-footer">
                            <a class="btn btn-primary" data-dismiss="modal">Voltar</a>
                        </div>
                    </div>
                </div>
            </div>

            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
            <script src="js/bootstrap.js"></script>

        </div>
    <?php $this->carregarRodape()?>

</body>

</html>