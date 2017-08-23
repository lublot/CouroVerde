<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!--Codificação dos caracteres: UTF-8-->
    <meta charset="utf-8" />
    <!--Descrição da página: Sertour-->
    <meta name="description" content="Setour" />
    <!--Regulando a visão da tela para a largura relativa à tela utilizada-->
    <meta name=viewport content="width=device-width, initial-scale=1" />

    <title>Gerenciamento de Funcionários</title>

    <!--Importação do CSS do Bootstrap, Bootflat e o pessoal (Estilos)-->
    <?php $this->carregarDependencias()?>
    <link rel="stylesheet" href=<?php $this->path("assets/css/adm.css")?>>
    <script src=<?php $this->path("assets/js/inicioFuncionario-script.js")?>></script>

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
                <h4 class="text-center">Quadro de Funcionários</h4>
            </div>
            <!--Fim do título da caixa-->

            <!-- Contorno -->
            <div id="contorno">
                <a href="#ajudafuncionario" data-toggle="modal" class="direita">Ajuda  <span></span></a>
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
            <div class="modal fade" id="ajudafuncionario" role="dialog">

            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Tiítulo do modal -->
                    <div class="modal-header">
                        <h2 style="margin-bottom: 1px;">Suporte ao usuário - Funcionário</h2>
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
                                            Como cadastrar um novo funcionário?
                                        </a>
                                        </h4>
                                    </div>

                                    <!-- Corpo do tópico -->
                                    <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="card-block">
                                            <ol>
                                                <li>Na barra lateral esquerda, clique em <strong>funcionários</strong> e em seguida
                                                    em <strong>cadastrar funcionário.</strong></li>
                                                <li>Preencha os campos com as informações do novo funcionário. Campos com * são obrigatórios e não podem ser deixados em branco.</li>
                                                <li>Marque as caixas com as permissões que você deseja que o novo funcionário possua</li>
                                                <li>clique em <img src=<?php $this->path("assets/images/cadastrar.png")?> style="width: 18%; height: 18%" /img> para finalizar o cadastro do funcionário</li>
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
                                            Como alterar o cadastro de um funcionário?
                                        </a>
                                        </h4>
                                    </div>
                                    <!-- Corpo do tópico -->
                                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                        <div class="card-block">
                                            <ol>
                                                <li>Na barra lateral esquerda, clique em <strong>funcionários</strong> e em seguida
                                                    em <strong>gerenciar funcionários</strong></li>
                                                <li>Selecione o funcionário cujo cadastro deseja alterar</li>
                                                <li>Modifique os campos que deseja alterar com as novas informações e marque/desmarque autorizações que você deseja conceder ou remover</li>
                                                <li>Clique em <img src=<?php $this->path("assets/images/atualizarInformacoes.png")?> style="width: 30%; height: 30%" /img> para salvar as modificações</li>
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
                                            Como remover o cadastro de um funcionário?
                                        </a>
                                        </h4>
                                    </div>
                                    <!-- Corpo do tópico -->
                                    <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
                                        <div class="card-block">

                                            <ol>
                                                <li>Na barra lateral esquerda, clique em <strong>funcionários</strong> e em seguida
                                                    em <strong>gerenciar funcionários</strong></li>
                                                <li>Selecione o funcionário que você deseja excluir</li>
                                                <li>Clique em <img src=<?php $this->path("assets/images/remover.png")?> style="width: 20%; height: 20%" /img> para salvar as modificações</li>
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
            </div>
    </div>
    <?php $this->carregarRodape()?>

</body>

</html>