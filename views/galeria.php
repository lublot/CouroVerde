<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <title>Sertour</title>
        <meta charset="utf-8">
        <meta name=viewport  content="width=device-width, initial-scale=1" />
        <?php $this->carregarDependenciasGaleria();?>
        <?php $this->carregarDependencias();?>
    </head>
    <body>
        <?php $this->carregarCabecalho();?>
            <div class="col-xs-3">
                <div class="panel-heading text-center">
                    <h4 class="panel-title">
                        <a>
                        <h5>CATEGORIAS</h5>
                        </a>
                    </h4>
                    <br>
                    <h4 class="panel-title">
                        <a>
                        Categoria 1
                        </a>
                    </h4>
                    <br>
                    <h4 class="panel-title">
                        <a>
                        Categoria 2
                        </a>
                    </h4>
                    <br>
                    <h4 class="panel-title">
                        <a>
                        Categoria 3
                        </a>
                    </h4>
                    <br>
                    <h4 class="panel-title">
                        <a>
                        Categoria 4
                        </a>
                    </h4>
                    <br>
                    <h4 class="panel-title">
                        <a>
                        Categoria 5
                        </a>
                    </h4>
                </div>
            </div>

            <!--Inicialização ainel lateral-->
            <!--Inicialização ainel lateral-->
        <br>
        <?php
            if(isset($_GET['id'])) {
                $obraController = new ObraController();
                $classificacaoEscolhida = $obraController->obterClassificacao($_GET['id']);
                
                echo '<!--Container que circunda a galeria-->
                        <div class="container" id="pagina" style="margin-top: 0; float: right;">
                            <div class="row text-right">
                                <!--Caso ele tenha escolhido alguma-->
                                <h4>'.$classificacaoEscolhida->getNome().'</h4> 
                            </div>';
                            
                    $obras = $obraController->obterObrasClassificacao($_GET['id']);
                    $numPag = 1;
                    $numImgsLinha = 0;
                    $numImgs = 0;
                    
                    foreach($obras as $obra) {
                        $numImgs++;
                        if($numImgsLinha == 0) {
                            // 1 row para cada colona de imagens
                            echo '<div class="row"> <!-abre linha-->';
                        }

                        $numImgsLinha = $numImgsLinha + 1;

                        echo '<!--um <col-xs-6 col-md-3> para cada imagem de obra a ser exibida-->
                                <div id="img'.$numImgs.'_'.$numPag.'" class="col-xs-6 col-md-3" hidden>
                                    <!--#href contendo o caminho para exibição da obra-->
                                    <a href="'.'../obra?num='.$obra->getNumInventario().'.php">
                                        <div class="thumbnail">
                                            <!--Caminho da imagem exibida representando uma obra-->
                                            <img src="'.$obra->getCaminhoImagem1().'" style="height:150px">
                                            <div class="caption">
                                                <h5>
                                                    <!--Nome da obra-->
                                                    '.$obra->getNome().'
                                                </h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>';

                        if($numImgsLinha == 4) {
                            echo '</div><!-fecha linha-->';                            
                            $numImgsLinha = 0;
                        }

                        if($numImgs == 8) {
                            $numImgs = 0;
                            $numPag++;
                        }

                    }
                }                
            ?>
            <div class="row text-center">
                <button type="button" class="btn btn-primary btn-mais">Carregar Mais</button>
            </div>
            <div class="row text-center">
                <button type="button" onclick="topFunction()" id="myBtn" class="btn btn-primary btn-voltar" style="display: none;">Voltar Ao Início</a>                                 
            </div>                
        </div>
        
    </body>
    <!--  -->  
</html>