<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!--Codificação dos caracteres: UTF-8-->
    <meta charset="utf-8" />
    <!--Descrição da página: Sertour-->
    <meta name="description" content="Setour" />
    <!--Regulando a visão da tela para a largura relativa à tela utilizada-->
    <meta name=viewport content="width=device-width, initial-scale=1" />

    <title>Cadastro de Notícias</title>

    <?php $this->carregarDependencias()?>

</head>

<body style="background-color: rgb(241, 242, 246);">

    <?php $this->carregarCabecalho()?>
    <!-- Container  -->
    <div class="container">

        <!-- Painel -->
        <div class="col-xs-3">
            <?php $this->carregarPainel()?>
        </div>

        <!-- Div cadastro-noticias -->
        <div id='cadastro-noticias' class="col-md-9 col-lg-9">

            <!--Título da caixa-->
            <div id="titulo">
                <h4 class='text-center'>Registro de Notícias</h4>
            </div>
            <!--Fim do título da caixa-->

            <!-- Contorno -->
            <div id="contorno">
                <a href="#ajudanoticia" data-toggle="modal" class="direita">Ajuda  <span></span></a>
                <!-- Caixa interna -->
                <section id="caixa">

                    <!-- Formulário de cadastro/alteração de notícias -->
                    <form data-toggle="validator" role="form" action="../noticias/cadastrar" method="POST" enctype="multipart/form-data">

                        <!-- Subtítulo -->
                        <div class="form-group">
                            <h5 class="text-center">Informações</h5>
                        </div>

                        <!-- Upload da imagem -->
                        <div class="form-group">
                            <div class="form-control " id="caixa-img">
                                <div class="fileUpload pull-right btn btn-default">
                                    <span>UPLOAD</span>
                                    <input id='selecao-arquivo' type="file" name="imagem" class="upload"  required>
                                </div>
                            </div>
                        </div>

                        <!-- Linha com duas entradas -->
                        <div class="form-group row">

                            <!-- Entrada do título -->
                            <div class="col-xs-6">
                                <input class="form-control" type="text" placeholder="Título(*)" name="titulo" id="inputName" data-error="Preencha este campo" required>
                            </div>

                            <!-- Entrada do subtítulo -->
                            <div class="col-xs-6">
                                <input class="form-control" type="text" placeholder="Subtitulo" name="subtitulo">
                            </div>

                            <!-- Fim Linha com duas entradas -->
                        </div>

                        <!-- TextArea com entrada da descrição -->
                        <div class="form-group ">
                            <textarea class="form-control" placeholder="Conteúdo(*)" type="text" rows="5" name="descricao" required></textarea>
                        </div>

                        <h6>(*) Campos obrigatórios</h6>

                        <!-- Linha com botões -->
                        <div class="row modal-footer">

                            <!-- Botão cancelar -->
                            <button type="button" class="pull-rigth btn btn-default" onclick="window.history.back()" name="btnCancelar">Cancelar</button>

                            <!-- Botão cadastrar ou botão alterar-->
                            <button type="submit" class="pull-rigth btn btn-default" name="btnCadNoticia"> Cadastrar</button>
                        </div>

                        <!-- Fim do Formulário de cadastro de notícias  -->
                    </form>
                    <!-- Fim da Caixa interna -->
                </section>

                <!-- Fim do contorno -->
            </div>

            <!-- Fim Div cadastro-noticias -->
        </div>

        <!-- Fim do container  -->
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

        </div>
    <?php $this->carregarRodape()?>
</body>
    <script src=<?php '"'.VIEW_BASE.'assets/js/moduloNoticia-script.js"' ?>></script>
</html>