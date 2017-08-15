<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!--Codificação dos caracteres: UTF-8-->
    <meta charset="utf-8" />
    <!--Descrição da página: Sertour-->
    <meta name="description" content="Setour" />
    <!--Regulando a visão da tela para a largura relativa à tela utilizada-->
    <meta name=viewport content="width=device-width, initial-scale=1" />

    <title>Gerenciamento de Notícias</title>

    <!--Importação do CSS do Bootstrap, Bootflat e o pessoal (Estilos)-->
    <link rel="stylesheet" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/bootstrap-theme.css" />
    <link rel="stylesheet" href="assets/css/estilo.css" />
    <link rel="stylesheet" href="assets/css/bootstrap-social.css" />
    <link rel="stylesheet" href="assets/css/site.css" />
    <link rel="stylesheet" href="assets/css/site.min.css" />
    <link rel="stylesheet" href="assets/css/adm.css" />


    <!--Importação do Javascript pessoal e jQuery  -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/cadObras-script.js"></script>
    <script src="assets/js/moduloNoticia-script.js"></script>

</head>

<body style="background-color: rgb(241, 242, 246);">

    <div class="container">
        <!-- Painel -->
        <div class="col-md-3 col-lg-3"></div>

        <div class="col-md-9 col-lg-9">

            <!--Título da caixa-->
            <div id="titulo">
                <h4 class="text-center">Gerenciamento de Notícias</h4>
            </div>
            <!--Fim do título da caixa-->

            <!-- Contorno -->
            <div id="contorno">

                <!-- Caixa interna -->
                <section id="caixa">

                    <!-- Inicio da caixa de busca-->
                    <div class="row busca">

                        <!-- Tamanho e posição do input de busca -->
                        <div class="col-lg-6 col-lg-offset-3">

                            <!-- Input de busca -->

                            <div class="search-only form-search">
                                <i class="search-icon fa fa-search"></i>
                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?> a=buscar" >
                                    <input type="text" class="form-control search-query input-sm" placeholder="Buscar por Titulo" id="CampoBusca" name="campoBusca" onKeyPress="return submitenter(this,event)"/>
                                </form>
                            </div>

                            <!-- FIM Tamanho e posição do input de busca -->
                        </div>

                        <!-- FIM da caixa de busca-->
                    </div>


                    <!-- Inicio da galeria -->
                    <div class="row" align="center" name="galeriaNoticias">

                        <?php
                            require_once '../vendor/autoload.php';
                            use \controllers\noticiaController as NoticiaController;
                            use \models\Noticia as Noticia;

                            $noticiaontroller = new NoticiaController();
                            $noticias = $noticiasController->listarTodasNoticias();

                            $a = $_GET['a'];
                            if ($a == "buscar") {
                                // Pegamos o titulo buscado
	                            $campoBusca = $_POST['campoBusca'];
                                foreach($noticias as $noticia) {
                                    if($campoBusca == $noticia->getTitulo()){
                                        echo "
                                            <form data-toggle='validator' role='form' method='POST' name='listaNoticias' id='listNoticias' action='cadNoticia.php'>
                                                <input type='hidden' name='idNoticia' value='".$noticia->getidNoticia()."'>
                                                <input type='hidden' name='imagem' value='".$noticia->getCaminhoImagem()."'>
                                                <input type='hidden' name='titulo' value='".$noticia->getTitulo()."'>
                                                <input type='hidden' name='subtitulo' value='".$noticia->getSubtitulo()."'>
                                                <input type='hidden' name='descricao' value='".$noticia->getDescricao()."'>
                                                <!-- Posição e tamanho do item da galeria. Isto que deve ser replicado com o PHP puxando
                                                as notícias do banco de dados-->
                                                <div class='gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter spray '>

                                                    <!-- Caixa do item -->
                                                    <div class='caixa-funcionario' id='caixa-funcionario'>

                                                        <!--BOTÃO A SER REDIRECIONADO COM AS INFORMAÇÕES DA NOTÍCIA -->
                                                        <div class='text-center'>

                                                            <!-- Título da notícia -->
                                                            <button type='submit' name='enviaNoticia' class='btn btn-link'><h5><dt>".$noticia->getTitulo()."</dt></h5></button>

                                                            <!-- FIM BOTÃO A SER REDIRECIONADO COM AS INFORMAÇÕES DA NOTÍCIA-->
                                                        </div>

                                                        <!-- FIM da Caixa do item -->
                                                    </div>

                                                <!-- /Posição e tamanho do item da galeria. Isto que deve ser replicado com o PHP puxando
                                                as noticias do banco de dados-->
                                                </div>
                                            </form>
                                        ";
                                    }
                                }

                            }

                            else{
                                foreach($noticias as $noticia) {
                                    echo "
                                        <form data-toggle='validator' role='form' method='POST' name='listaNoticias' id='listNoticias' action='cadNoticia.php'>
                                            <input type='hidden' name='idNoticia' value='".$noticia->getidNoticia()."'>
                                            <input type='hidden' name='imagem' value='".$noticia->getCaminhoImagem()."'>
                                            <input type='hidden' name='titulo' value='".$noticia->getTitulo()."'>
                                            <input type='hidden' name='subtitulo' value='".$noticia->getSubtitulo()."'>
                                            <input type='hidden' name='descricao' value='".$noticia->getDescricao()."'>
                                            <!-- Posição e tamanho do item da galeria. Isto que deve ser replicado com o PHP puxando
                                            as notícias do banco de dados-->
                                            <div class='gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter spray '>

                                                <!-- Caixa do item -->
                                                <div class='caixa-funcionario' id='caixa-funcionario'>

                                                    <!--BOTÃO A SER REDIRECIONADO COM AS INFORMAÇÕES DA NOTÍCIA -->
                                                    <div class='text-center'>

                                                        <!-- Título da notícia -->
                                                        <button type='submit' name='enviaNoticia' class='btn btn-link'><h5><dt>".$noticia->getTitulo()."</dt></h5></button>

                                                        <!-- FIM BOTÃO A SER REDIRECIONADO COM AS INFORMAÇÕES DA NOTÍCIA-->
                                                    </div>

                                                    <!-- FIM da Caixa do item -->
                                                </div>

                                            <!-- /Posição e tamanho do item da galeria. Isto que deve ser replicado com o PHP puxando
                                            as noticias do banco de dados-->
                                            </div>
                                        </form>
                                    ";
                                }
                            }
                        ?>

                        <!-- /FIM da galeria -->
                    </div>

                    <!-- /FIM da Caixa interna -->
                </section>

                <!-- FIM do Contorno -->
            </div>


        </div>
    </div>


</body>

</html>