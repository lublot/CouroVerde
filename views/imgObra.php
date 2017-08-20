<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!--Codificação dos caracteres: UTF-8-->
    <meta charset="utf-8" />
    <!--Descrição da página: Sertour-->
    <meta name="description" content="Setour" />
    <!--Regulando a visão da tela para a largura relativa à tela utilizada-->
    <meta name=viewport content="width=device-width, initial-scale=1" />

    <title>Visualização de obras</title>

    <!--Importação do Javascript pessoal e jQuery  -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/backup-script.js"></script>
    

    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>   

    <?php $this->carregarDependencias();?>
    <script src="views/assets/js/imgObra-script.js"></script>
 

</head>

<body>
    <?php $this->carregarCabecalho();?>    

    <!-- Container principal -->
    <div class="container">
        
        <!-- Head da vizualização de obras -->
        <div class="container">
            <div class="row">
                <!-- Botão para voltar para obra anterior da galeria -->
                <div class="col-sm-2 col-md-2">
                    <?php
                        use \controllers\obraController as ObraController;  
                        use \models\Obra as Obra;  
                        use \DAO\obraDao as ObraDAO;
                        use \DAO\UsuarioAcessoDAO as UsuarioAcessoDAO;
                        use \models\Visita as Visita;
                        
                        if(isset($_GET['num'])){
                            $obraDAO = new ObraDAO();
                            $obraController = new ObraController();

                            if(isset($_SESSION['id'])) {
                                $usuarioAcessoDAO = new UsuarioAcessoDAO();
                                $visitas = $usuarioAcessoDAO->buscar(array(), array('numeroInventario' => $_GET['num'], 'idUsuario' => $_SESSION['id']));
                                
                                $numInventario = explode('.php', $_GET['num']);
                                $numInventario = $numInventario[0];

                                if(count($visitas) <= 0) {
                                    $usuarioAcessoDAO->inserir(new Visita($_SESSION['id'], $numInventario));
                                }
                            }

                            $obraPagina = $obraDAO->buscar(array(), array("numeroInventario" => $_GET['num']))[0];
                            $obrasClassificacao = $obraController->obterObrasClassificacao($obraPagina->getIdClassificacao());
                            $cont = 0;

                            while($cont < count($obrasClassificacao) && $obraPagina->getNumInventario() != $obrasClassificacao[$cont]->getNumInventario()) {
                                $cont = $cont + 1;
                            }

                            if(array_key_exists($cont-1, $obrasClassificacao)) {
                                $obraAnterior = $obrasClassificacao[$cont-1];
                            } else {
                                $obraAnterior = $obraPagina;
                            }

                            if(array_key_exists($cont+1, $obrasClassificacao)) {
                                $obraProxima = $obrasClassificacao[$cont+1];
                            } else {
                                $obraProxima = $obraPagina;
                            }     

                            echo '<a type="button" href="/obra?num='.$obraAnterior->getNumInventario().'" class="btn btn-primary btn-sm">';                       
                        } else {
                            if( !headers_sent() ){
                                    header("Location: ../views/erro404.php");
                            }else{
                                ?>
                                    <script type="text/javascript">
                                    document.location.href="../views/erro404.php";
                                    </script>
                                    Redirecting to <a href="../views/erro404.php">views/erro404.php</a>
                                <?php
                            }
                            die();                              
                        }
                    ?>
                        <img src="../views/assets/images/glyphicons-211-arrow-left.png"></img>   
                        Obra Anterior
                    </a>
                </div>

                <!-- Botão para voltar para obra anterior da galeria -->
                <div class="col-sm-8 col-md-8 text-center">
                    <h3 class=""><?php echo $obraPagina->getNome() ?></h3>
                    <!-- Botão para Modelo 3D -->
                    <div>
                        <?php
                            if(isset($_GET['num']) && $obraPagina->getCaminhoModelo3D() != null && $obraPagina->getCaminhoModelo3D() != '') {
                                echo '<button class="btn btn-primary btn-sm" onClick="modelo3D('. "'" . $obraPagina->getCaminhoModelo3D() . "'" .')">';
                                echo 'Modelo 3D';
                            }
                        ?>
                        </button>
                    </div>
                    <br>
                </div>  

                <!-- Botão para voltar para próxima obra da galeria -->
                <div class="col-sm-2 col-md-2">
                    <?php
                        if(isset($_GET['num'])) {
                            echo '<a type="button" href="/obra?num='.$obraProxima->getNumInventario().'" class="btn btn-primary btn-sm">';
                        }
                    ?>
                        Próxima obra
                        <img src="../views/assets/images/glyphicons-212-arrow-right.png"></img>                           
                    </a>
                </div>
            </div>
        </div>
        <!-- /Head da vizualização de obras -->

        <!-- Imagens da obra -->
        <div class="container">
            <div class="carousel slide article-slide center" id="article-photo-carousel">

                <!-- OBS: AS IMAGENS GRANDES DEVEM ESTÁ NA MESMA ORDEM PARA COINCIDIREM COM AS PEQUENAS -->

                <!-- Imagens Grandes -->
                <div class="row">

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner cont-slider">
                        <?php
                            use util\ValidacaoDados as ValidacaoDados;
                            $imgs = array();

                            $caminhoImg1 = ValidacaoDados::validarCampo($obraPagina->getCaminhoImagem1()) ? $obraPagina->getCaminhoImagem1() : null;
                            $imgs[] = ValidacaoDados::validarCampo($obraPagina->getCaminhoImagem2()) ? $obraPagina->getCaminhoImagem2() : null;
                            $imgs[] = ValidacaoDados::validarCampo($obraPagina->getCaminhoImagem3()) ? $obraPagina->getCaminhoImagem3() : null;
                            $imgs[] = ValidacaoDados::validarCampo($obraPagina->getCaminhoImagem4()) ? $obraPagina->getCaminhoImagem4() : null;
                            $imgs[] = ValidacaoDados::validarCampo($obraPagina->getCaminhoImagem5()) ? $obraPagina->getCaminhoImagem5() : null;

                        ?>

                        <div class="item active center">
                            <img alt="" title="" src="<?php echo $caminhoImg1 ?>">
                        </div>

                        <?php
                            foreach($imgs as $img) {
                                if($img != null) {
                                    echo '<div class="item center">
                                        <img alt="" title="" src="'.$img.'">
                                        </div>';
                                }
                            }
                        ?>                        
                    </div>
                </div>

                <!-- Imagens pequenas -->
                <div class="row center" style="padding-top: 12vh;">

                    <!-- Indicators -->
                    <ol class="carousel-indicators" style="padding-left: 3vh;">
                        <?php
                            if($imgs[0] != null) {
                                echo '<li class="active" data-slide-to="0" data-target="#article-photo-carousel">
                                    <img alt="" src="'.$caminhoImg1.'">
                                    </li>';
                            }

                            $cont = 0;
                            foreach($imgs as $img) {
                                $cont++;
                                if($img != null) {
                                    echo '<li class="" data-slide-to="'.$cont.'" data-target="#article-photo-carousel">
                                            <img alt="" src="'.$img.'">
                                        </li>';
                                }
                            }
                        ?>                       

                    </ol>
                </div>
            </div>
        </div>
        <!--Informações da obra -->
        <!-- Borda da caixa -->
        <div class="container caixa-informacoes-obra center" style="height: auto">
            <!--Título da obra -->
            <h4 class="text-center"><?php echo 'Identificação do Objeto' ?></h4>

            <!-- Demais informações -->
            <p><b>Título:</b> <?php echo $obraPagina->getTitulo() ?></p>
            <?php 
                if($obraPagina->getFuncao() != null && $obraPagina->getFuncao() != '') {
                    echo '<p><b>Função:</b>'.$obraPagina->getFuncao().'</p>';
                } else {
                    echo '<p><b>Função:</b> Não Informado </p>';                    
                }

                if($obraPagina->getOrigem() != null && $obraPagina->getOrigem() != '') {
                    echo '<p><b>Origem:</b>'.$obraPagina->getOrigem().'</p>';
                } else {
                    echo '<p><b>Origem:</b> Não Informado </p>';                    
                }

                if($obraPagina->getProcedencia() != null && $obraPagina->getProcedencia() != '') {
                    echo '<p><b>Procedência:</b>'.$obraPagina->getProcedencia().'</p>';
                } else {
                    echo '<p><b>Procedência:</b> Não Informado </p>';                    
                }

                if($obraPagina->getDescricao() != null && $obraPagina->getDescricao() != '') {
                    echo '<p><b>Descrição:</b>'.$obraPagina->getDescricao().'</p>';
                } else {
                    echo '<p><b>Descrição:</b> Não Informado </p>';                    
                }

                $colecaoNome = $obraController->obterColecao($obraPagina->getIdColecao())[0]->getNome();
                $classificacaoNome = $obraController->obterClassificacao($obraPagina->getIdClassificacao())->getNome();

                echo '<p><b>Coleção:</b> '. $colecaoNome .'</p>';
                echo '<p><b>Classificação:</b> '. $classificacaoNome .'</p>';

                echo '<hr>';
                echo '<h4 class="text-center">Dimensões da Objeto</h4>';

                if($obraPagina->getAltura() != null && $obraPagina->getAltura() != '') {
                    echo '<p><b>Altura:</b> '.$obraPagina->getAltura().'</p>';
                } else {
                    echo '<p><b>Altura:</b> Não Informado </p>';                    
                }


                if($obraPagina->getDiametro() != null && $obraPagina->getDiametro() != '') {
                    echo '<p><b>Diâmetro:</b> '.$obraPagina->getDiametro().'</p>';
                } else {
                    echo '<p><b>Diâmetro:</b> Não Informado </p>';                    
                }


                if($obraPagina->getPeso() != null && $obraPagina->getPeso() != '') {
                    echo '<p><b>Peso:</b> '.$obraPagina->getPeso().'</p>';
                } else {
                    echo '<p><b>Peso:</b> Não Informado </p>';                    
                }


                if($obraPagina->getComprimento() != null && $obraPagina->getComprimento() != '') {
                    echo '<p><b>Comprimento:</b> '.$obraPagina->getComprimento().'</p>';
                } else {
                    echo '<p><b>Comprimento:</b> Não Informado </p>';                    
                }
   

                echo '<hr>';
                echo '<h4 class="text-center">Características Estilísticas</h4>';                

                if($obraPagina->getMateriais() != null && $obraPagina->getMateriais() != '') {
                    echo '<p><b>Materiais Constituintes:</b> '.$obraPagina->getMateriais().'</p>';
                } else {
                    echo '<p><b>Materiais Constituintes:</b> Não Informado </p>';                    
                }


                if($obraPagina->getTecnicas() != null && $obraPagina->getTecnicas() != '') {
                    echo '<p><b>Técnicas de Fabricação:</b> '.$obraPagina->getTecnicas().'</p>';
                } else {
                    echo '<p><b>Técnicas de Fabricação:</b> Não Informado </p>';                    
                }


                if($obraPagina->getAutoria() != null && $obraPagina->getAutoria() != '') {
                    echo '<p><b>Autoria:</b> '.$obraPagina->getAutoria().'</p>';
                } else {
                    echo '<p><b>Autoria:</b> Não Informado </p>';                    
                }


                echo '<hr>';
                echo '<h4 class="text-center"> Marcas e Inscrições</h4>';                   

                if($obraPagina->getMarcas() != null && $obraPagina->getMarcas() != '') {
                    echo '<p>'.$obraPagina->getMarcas().'</p>';
                }  else {
                    echo '<p> Não Informado </p>';                    
                }


                echo '<hr>';
                echo '<h4 class="text-center">Histórico do Objeto</h4>';                                    

                if($obraPagina->getHistorico() != null && $obraPagina->getHistorico() != '') {
                    echo '<p>'.$obraPagina->getHistorico().'</p>';
                }  else {
                    echo '<p>Não Informado </p>';                    
                }


                echo '<hr>';
                echo '<h4 class="text-center">Aquisição</h4>';                     

                if($obraPagina->getModoAquisicao() != null && $obraPagina->getModoAquisicao() != '') {
                    echo '<p><b>Modo de Aquisição:</b>'.$obraPagina->getModoAquisicao().'</p>';
                } else {
                    echo '<p><b>Modo de Aquisição:</b> Não Informado </p>';                    
                }
          

                if($obraPagina->getAutor() != null && $obraPagina->getAutor() != '') {
                    echo '<p><b>Responsável pela Aquisição:</b> '.$obraPagina->getAutor().'</p>';
                } else {
                    echo '<p><b>Responsável pela Aquisição:</b> Não Informado </p>';                    
                }
              

                if($obraPagina->getDataAquisicao() != null && $obraPagina->getDataAquisicao() != '') {
                    echo '<p><b>Data de Aquisição:</b>'.$obraPagina->getDataAquisicao().'</p>';
                } else {
                    echo '<p><b>Data de Aquisição:</b> Não Informado </p>';                    
                }
      

                echo '<hr>';
                echo '<h4 class="text-center">Estado de Conservação</h4>';    

                if($obraPagina->getEstado() != null && $obraPagina->getEstado() != '') {
                    echo '<p>'.$obraPagina->getEstado().'</p>';
                } else {
                    echo '<p>Não Informado </p>';                    
                }
   
            ?>
        </div>
        <br><br>
        <!-- Botão para voltar para a galeria -->
        <div class="row">
            <?php 
                
                if(isset($_GET['num'])){
                    $obraDAO = new ObraDAO();

                    $obra = $obraDAO->buscar(array(), array("numeroInventario" => $_GET['num']))[0];   

                    $galeriaLink = '/galeria/?id='.$obra->getIdClassificacao();
                } else {
                    $galeriaLink = '/galeria';
                }
                echo '<a href="'.$galeriaLink.'" class="btn btn-primary btn-sm" style="border:none">';
            ?>
                <img src="../views/assets/images/if_arrow-back_216437.png"></img>                    
                Voltar Para Galeria
            </a>
        </div>
    
    </div>

    <?php $this->carregarRodape();?>    
    
</body>

<script type="text/javascript ">
    $('.carousel').carousel({
        interval: false
    });
</script>

</html>