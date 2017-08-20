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

    <script src="assets/js/moduloNoticia-script.js"></script>


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

                <!-- Caixa interna -->
                <section id="caixa">

                    <!-- Formulário de cadastro/alteração de notícias -->
                    <form data-toggle="validator" role="form" method="POST" enctype="multipart/form-data">

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

    <?php $this->carregarRodape()?>
</body>

</html>