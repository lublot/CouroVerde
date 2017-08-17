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
                <?php
                    if (isset($_POST['enviaNoticia'])){
                        echo "<h4 class='text-center'>Informações da Notícias</h4>";
                    }
                    else {
                        echo "<h4 class='text-center'>Registro de Notícias</h4>";
                    }
                ?>
            </div>
            <!--Fim do título da caixa-->

            <!-- Contorno -->
            <div id="contorno">

                <!-- Caixa interna -->
                <section id="caixa">

                    <!-- Formulário de cadastro/alteração de notícias -->
                    <form data-toggle="validator" role="form" method="POST" name="formCad" id="form-CadNoticia" class="form-horizontal" onsubmit="" action="<?php if(isset($_POST['enviaNoticia'])){echo'/noticia/alteraNoticia.php'} else{echo'/noticia/salvaNoticia.php'}?>">

                        <!-- Subtítulo -->
                        <div class="form-group">
                            <h5 class="text-center">Informações</h5>
                        </div>

                        <!-- Upload da imagem -->
                        <div class="form-group">
                            <div class="form-control " id="caixa-img">
                                <div class="fileUpload pull-right btn btn-default">
                                    <span>UPLOAD</span>
                                    <input id='selecao-arquivo' type="file" name="imagem" class="upload" value="<?php if (isset($_POST['enviaNoticia'])){$imagem = $_POST['imagem']; echo $imagem;}?>" onchange="verificarImagem(this);" required>
                                </div>
                            </div>
                        </div>

                        <!-- Linha com duas entradas -->
                        <div class="form-group row">

                            <!-- Entrada do título -->
                            <div class="col-xs-6">
                                <input class="form-control" type="text" placeholder="Título(*)" name="titulo" id="inputName" value="<?php if (isset($_POST['enviaNoticia'])){$titulo = $_POST['titulo']; echo $titulo;}?>" data-error="Preencha este campo" required>
                            </div>

                            <!-- Entrada do subtítulo -->
                            <div class="col-xs-6">
                                <input class="form-control" type="text" placeholder="Subtitulo" name="subtitulo" value="<?php if (isset($_POST['enviaNoticia'])){$subtitulo = $_POST['subtitulo']; echo $subtitulo;}?>">
                            </div>

                            <!-- Fim Linha com duas entradas -->
                        </div>

                        <!-- TextArea com entrada da descrição -->
                        <div class="form-group ">
                            <textarea class="form-control" placeholder="Descrição(*)" type="text" rows="5" name="descricao" value="<?php if (isset($_POST['enviaNoticia'])){$descricao = $_POST['descricao']; echo $descricao;}?>" required></textarea>
                        </div>

                        <h6>(*) Campos obrigatórios</h6>

                        <!-- Linha com botões -->
                        <div class="row modal-footer">

                            <!-- Botão cancelar -->
                            <button type="button" class="pull-rigth btn btn-default" onclick="atualizarPagina()" name="btnCancelar">CANCELAR</button>

                            <!-- Botão cadastrar ou botão alterar-->
                            <button type="submit" class="pull-rigth btn btn-default" name="btnCadNoticia"> <?php if (isset($_POST['enviaNoticia'])){echo 'ALTERAR';} else{echo 'CADASTRAR';} ?> </button>
                            <?php
                                if (isset($_POST['enviaNoticia'])){
                                    echo '
                                        <form name="formRemoveNoticia" method="POST" action="/noticia/removeNoticia.php">
                                            <input type="hidden" name="idNoticia" value="'.$noticia->getidNoticia().'">
                                            <button type="submit" class="pull-rigth btn btn-danger" name="btnApagaNoticia">REMOVER</button>
                                        </form>
                                    ';
                                }
                            ?>
                        </div>

                        <!-- Fim do Formulário de cadastro de notícias  -->
                    </form>
                    
                    <?php
                        unset($_POST['enviaNoticia']);
                    ?>

                    <!-- Fim da Caixa interna -->
                </section>

                <!-- Fim do contorno -->
            </div>

            <!-- Fim Div cadastro-noticias -->
        </div>

        <!-- Fim do container  -->
    </div>

    <!-- Footer -->
    <footer class="footer-distributed">

        <div class="footer-left">

            <h3>Sertour</h3>

            <p class="footer-company-name">MItologic Software® &copy; 2017</p>
        </div>

        <div class="footer-center">

            <p class="footer-links">
                <a href="#">Home</a>
                <a href="#">Galeria</a>
                <a href="#">Sobre</a>
            </p>

        </div>

        <div class="footer-right">

            <div class="footer-icons">
                <p style="text-align: center;">
                    <a href="#"><i class="fa fa-twitter"></i></a>
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-google-plus"></i></a>
                </p>

            </div>


        </div>

    </footer>
    <!-- /Footer -->

</body>

</html>