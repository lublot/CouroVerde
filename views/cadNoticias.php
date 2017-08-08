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

    <!--Importação do CSS do Bootstrap, Bootflat e o pessoal (Estilos)-->
    <link rel="stylesheet" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/bootstrap-theme.css" />
    <link rel="stylesheet" href="assets/css/estilo.css" />
    <link rel="stylesheet" href="assets/css/bootstrap-social.css" />
    <link rel="stylesheet" href="assets/css/site.css" />
    <link rel="stylesheet" href="assets/css/site.min.css" />

    <!--Importação do Javascript pessoal e jQuery  -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="assets/js/validator.js"></script>
    <script src="assets/js/cadastroNoticia-script.js"></script>


</head>

<body style="background-color: rgb(241, 242, 246);">

    <!-- Container  -->
    <div class="container">

        <!-- Painel -->
        <div class="col-md-3 col-lg-3"></div>

        <!-- Div cadastro-noticias -->
        <div id='cadastro-noticias' class="col-md-9 col-lg-9">

            <!--Título da caixa-->
            <div id="titulo">
                <h4 class="text-center">Registro de Notícias</h4>
            </div>
            <!--Fim do título da caixa-->

            <!-- Contorno -->
            <div id="contorno">

                <!-- Caixa interna -->
                <section id="caixa">

                    <!-- Formulário de cadastro de notícias -->
                    <form data-toggle="validator" role="form" method="POST" name="formCad" id="form-CadNoticia" class="form-horizontal" onsubmit="" action="/noticia/salvaNoticia.php">

                        <!-- Subtítulo -->
                        <div class="form-group">
                            <h5 class="text-center">Informações</h5>
                        </div>

                        <!-- Upload da imagem -->
                        <div class="form-group">
                            <div class="form-control " id="caixa-img">
                                <div class="fileUpload pull-right btn btn-default">
                                    <span>UPLOAD</span>
                                    <input id='selecao-arquivo' type="file" name="imagem" class="upload" onChange="verificarImagem(this);">
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
                            <textarea class="form-control" placeholder="Descrição(*)" type="text" rows="5" name="descricao" required></textarea>
                        </div>

                        <h6>(*) Campos obrigatórios</h6>

                        <!-- Linha com botões -->
                        <div class="row modal-footer">

                            <!-- Botão cancelar -->
                            <button type="button" class="pull-rigth btn btn-default" onclick="atualizarPagina()" name="btnCancelar">CANCELAR</button>

                            <!-- Botão cadastrar -->
                            <button type="submit" class="pull-rigth btn btn-default" name="btnCadNoticia">CADASTRAR</button>
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



</body>

</html>